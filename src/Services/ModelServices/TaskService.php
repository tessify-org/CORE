<?php

namespace Tessify\Core\Services\ModelServices;

use DB;
use Auth;
use Users;
use Skills;
use Projects;
use TaskStatuses;
use TaskCategories;
use TaskSeniorities;
use App\Models\User;
use Tessify\Core\Models\Task;
use Tessify\Core\Models\Project;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Projects\Tasks\CreateTaskRequest;
use Tessify\Core\Http\Requests\Projects\Tasks\UpdateTaskRequest;

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
        // Preload relationships
        $instance->status = TaskStatuses::findForTask($instance);
        $instance->category = TaskCategories::findForTask($instance);
        $instance->seniority = TaskSeniorities::findForTask($instance);
        $instance->skills = $this->getRequiredSkills($instance);
        $instance->users = $this->getAssignedUsers($instance);

        // Add HREF to the view task page for this task
        $project = Projects::find($instance->project_id);
        $instance->view_href = route("projects.tasks.view", ["slug" => $project->slug, "taskSlug" => $instance->slug]);

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
                $out = Users::findPreloaded($userPivot->user_id);
            }
        }

        return $out;
    }

    public function getRequiredSkills(Task $task)
    {
        $out = [];

        foreach ($this->getSkillPivots() as $skillPivot)
        {
            if ($skillPivot->task_id == $task->id)
            {
                $out[] = Skills::find($skillPivot->skill_id);
            }
        }

        return $out;
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

    public function createFromRequest(Project $project, CreateTaskRequest $request)
    {
        $open = TaskStatuses::findByName("open");

        return Task::create([
            "project_id" => $project->id,
            "task_status_id" => $open->id,
            "task_category_id" => $request->task_category_id,
            "task_seniority_id" => $request->task_seniority_id,
            "title" => $request->title,
            "description" => $request->description,
            "complexity" => $request->complexity,
            "estimated_hours" => $request->estimated_hours,
        ]);
    }

    public function updateFromRequest(Task $task, UpdateTaskRequest $request)
    {
        $task->task_status_id = $request->task_status_id;
        $task->task_category_id = $request->task_category_id;
        $task->task_seniority_id = $request->task_seniority_id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->complexity = $request->complexity;
        $task->estimated_hours = $request->estimated_hours;
        $task->realized_hours = $request->realized_hours;
        $task->save();
    }

    public function hasAvailableSlot(Task $task)
    {
        return $task->num_positions > $task->users->count();
    }

    public function assignedToUser(Task $task, User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        foreach ($task->users as $assignedUser)
        {
            if ($assignedUser->id == $user->id) return true;
        }

        return false;
    }

    public function assignToUser(Task $task, User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        $task->users()->attach($user->id);
    }

    public function unassignUser(Task $task, User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        $task->users()->detach($user->id);
    }
}