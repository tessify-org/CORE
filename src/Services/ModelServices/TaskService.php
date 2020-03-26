<?php

namespace Tessify\Core\Services\ModelServices;

use DB;
use Auth;
use Users;
use Skills;
use Projects;
use CompletedTasks;
use TaskStatuses;
use TaskCategories;
use TaskSeniorities;
use TaskProgressReports;
use TaskProgressReportReviews;
use App\Models\User;
use Tessify\Core\Models\Task;
use Tessify\Core\Models\Project;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Tasks\CreateTaskRequest;
use Tessify\Core\Http\Requests\Tasks\UpdateTaskRequest;

class TaskService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    private $userPivots;
    private $skillPivots;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\Task";
    }
    
    public function preload($instance)
    {
        // Add HREF to the view task page for this task
        $project = Projects::find($instance->project_id);
        $instance->view_href = route("tasks.view", ["slug" => $instance->slug]);

        // Add flags to the instance
        $instance->is_owner = $this->userOwnsTask($instance);
        $instance->is_project_owner = $this->userOwnsTaskProject($instance);
        $instance->is_open = $this->hasAvailableSlots($instance);
        $instance->is_assigned = $this->assignedToUser($instance);
        $instance->num_open_positions = $this->numAvailableSlots($instance);
        $instance->completed = $this->hasBeenCompleted($instance);

        // Preload relationships
        $instance->author = Users::findPreloaded($instance->author_id);
        $instance->status = TaskStatuses::findForTask($instance);
        $instance->category = TaskCategories::findForTask($instance);
        $instance->seniority = TaskSeniorities::findForTask($instance);
        $instance->skills = Skills::getAllForTask($instance);
        $instance->users = $this->getAssignedUsers($instance);
        $instance->reports = TaskProgressReports::getAllForTask($instance);
        $instance->outstanding_reports = TaskProgressReports::getAllOutstandingForTask($instance);
        $instance->has_outstanding_reports = count($instance->outstanding_reports) > 0;
        $instance->has_unread_reviews = $this->hasUnreadReviews($instance->outstanding_reports);
        
        // Return instance
        return $instance;
    }

    public function getUserPivots()
    {
        if (is_null($this->userPivots))
        {
            $this->userPivots = DB::table("task_user")->get();
        }

        return $this->userPivots;
    }

    public function getSkillPivots()
    {
        if (is_null($this->skillPivots))
        {
            $this->skillPivots = DB::table("skill_task")->get();
        }

        return $this->skillPivots;
    }

    public function getAssignedUsers(Task $task)
    {
        $out = [];

        foreach ($this->getUserPivots() as $userPivot)
        {
            if ($userPivot->task_id == $task->id)
            {
                $out[] = Users::findPreloaded($userPivot->user_id);
            }
        }

        return collect($out);
    }

    public function getAllForProject(Project $project)
    {
        $out = [];

        foreach ($this->getAllPreloaded() as $task)
        {
            if ($task->project_id == $project->id)
            {
                $out[] = $task;
            }
        }

        return $out;
    }

    public function getAllForUser(User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        $out = [];

        foreach ($this->getAllPreloaded() as $task)
        {
            if ($this->assignedToUser($task, $user) and $task->status->name != "completed")
            {
                $out[] = $task;
            }
        }

        return collect($out);
    }

    public function getAllOngoingForUser(User $user = null)
    {
        $tasks = $this->getAllForUser($user)
            ->map(function($task) {
                return $task->status->name !== "completed" ? $task : false;
            })
            ->reject(function($task) {
                return $task === false;
            });

        return $tasks;
    }

    public function findBySlug($slug)
    {
        foreach ($this->getAll() as $task)
        {
            if ($task->slug == $slug)
            {
                return $task;
            }
        }

        return false;
    }

    public function findPreloadedBySlug($slug)
    {
        foreach ($this->getAllPreloaded() as $task)
        {
            if ($task->slug == $slug)
            {
                return $task;
            }
        }

        return false;
    }

    public function createFromRequest(CreateTaskRequest $request)
    {
        $open = TaskStatuses::findByName("open");

        $task = Task::create([
            "project_id" => $request->project_id,
            "author_id" => Auth::user()->id,
            "task_status_id" => $open->id,
            "task_category_id" => $request->task_category_id,
            "task_seniority_id" => $request->task_seniority_id,
            "title" => $request->title,
            "description" => $request->description,
            "complexity" => $request->complexity,
            "estimated_hours" => $request->estimated_hours,
            "urgency" => $request->urgency
        ]);
    
        if ($request->required_skills !== "[]")
        {
            $skills = json_decode($request->required_skills);
            if (is_array($skills) and count($skills))
            {
                $task->skills()->detach();
                foreach ($skills as $skillData)
                {
                    $skill = Skills::findOrCreateByName($skillData->skill);
                    $task->skills()->attach($skill->id, [
                        "required_mastery" => $skillData->required_mastery,
                        "description" => $skillData->description,
                    ]);
                }
            }
        }

        return $task;
    }

    public function updateFromRequest(Task $task, UpdateTaskRequest $request)
    {
        $task->project_id = $request->project_id;
        $task->task_status_id = $request->task_status_id;
        $task->task_category_id = $request->task_category_id;
        $task->task_seniority_id = $request->task_seniority_id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->complexity = $request->complexity;
        $task->estimated_hours = $request->estimated_hours;
        $task->realized_hours = is_null($request->realized_hours) ? 0 : $request->realized_hours;
        $task->urgency = $request->urgency;
        $task->save();

        $task->skills()->detach();
        
        if ($request->required_skills !== "[]")
        {
            $skills = json_decode($request->required_skills);
            if (is_array($skills) and count($skills))
            {
                $task->skills()->detach();
                foreach ($skills as $skillData)
                {
                    $skill = Skills::findOrCreateByName($skillData->skill);
                    $task->skills()->attach($skill->id, [
                        "required_mastery" => $skillData->required_mastery,
                        "description" => $skillData->description,
                    ]);
                }
            }
        }

        return $task;
    }

    public function hasAvailableSlots(Task $task)
    {
        return $task->num_positions > $task->users->count();
    }

    public function numAvailableSlots(Task $task)
    {
        return $task->num_positions - $task->users->count();
    }

    public function hasNoAssignedUsers(Task $task)
    {
        return $task->users->count() == 0;
    }

    public function hasBeenCompleted(Task $task)
    {
        return $task->status and $task->status->name == "completed";
    }

    public function assignedToUser(Task $task, User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        foreach ($user->tasks as $userTask)
        {
            if ($task->id == $userTask->id)
            {
                return true;
            }            
        }

        return false;
    }

    public function assignToUser(Task $task, User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        $task->users()->attach($user->id);

        $task = Task::find($task->id);

        if (!$this->hasAvailableSlots($task) and $this->hasStatus($task, "open"))
        {
            $this->updateStatus($task, "in_progress");
        }

        return $task;
    }

    public function unassignUser(Task $task, User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        $task->users()->detach($user->id);

        $task = Task::find($task->id);

        // dd($this->hasNoAssignedUsers($task), $task->users->count(), $this->hasStatus($task, "in_progress"));
        if ($this->hasNoAssignedUsers($task) and $this->hasStatus($task, "in_progress"))
        {
            $this->updateStatus($task, "open");
        }

        return $task;
    }

    public function numCompletedForUser(User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        $out = 0;

        foreach ($this->getAll() as $task)
        {
            if ($this->assignedToUser($task, $user) and $task->status->name == "completed")
            {
                $out += 1;
            }
        }

        return $out;
    }

    public function userOwnsTask(Task $task, User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        return $task->author_id == $user->id or ($task->project and $task->project->author_id == $user->id);
    }

    public function userOwnsTaskProject(Task $task, User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        return $task->project and $task->project->author_id == $user->id;
    }

    public function hasUnreadReviews(array $outstandingReports)
    {
        foreach ($outstandingReports as $report)
        {
            if (count($report->reviews))
            {
                foreach ($report->reviews as $review)
                {
                    if (!$review->read_by_assigned_user)
                    {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function complete(Task $task)
    {
        // Update the task's status to completed
        $completedStatus = TaskStatuses::findByName("completed");
        if ($completedStatus)
        {
            $task->task_status_id = $completedStatus->id;
            $task->save();
        }

        // Created 'CompletedTask' records for all of the assigned users
        foreach ($task->users as $user)
        {
            CompletedTasks::create($task, $user);
        }
        
        // Detaching the users is performed in the TaskEventSubscriber in a listener
        // That way we know which users completed the task so rewards can be rewarded
        // before detaching all users from the completed task
        
        // Return the task
        return $task;
    }

    public function unassignAllUsers(Task $task)
    {
        $task->users()->detach();
    }

    public function hasStatus(Task $task, $name)
    {
        return $task->status->name == $name;
    }

    public function updateStatus(Task $task, $name)
    {
        $status = TaskStatuses::findByName($name);
        if ($status)
        {
            $task = $this->find($task->id);
            $task->task_status_id = $status->id;
            $task->save();
        }
    }
}