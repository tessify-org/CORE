<?php

namespace Tessify\Core\Services\ModelServices;

use DB;
use Auth;
use Tags;
use Users;
use Dates;
use Skills;
use Projects;
use Uploader;
use Messages;
use Ministries;
use Organizations;
use OrganizationDepartments;
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
use Tessify\Core\Events\Tasks\TaskCreated;
use Tessify\Core\Events\Tasks\TaskUpdated;
use Tessify\Core\Events\Tasks\TaskDeleted;
use Tessify\Core\Events\Tasks\TaskProgressReported;
use Tessify\Core\Events\Tasks\TaskAssigned;
use Tessify\Core\Events\Tasks\TaskUnassigned;
use Tessify\Core\Events\Tasks\TaskCompleted;
use Tessify\Core\Events\Users\UserCreatedTask;
use Tessify\Core\Events\Users\UserUpdatedTask;
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
        $instance->has_available_slots = $this->hasAvailableSlots($instance);
        $instance->assigned_to_user = $this->assignedToUser($instance);
        $instance->num_open_positions = $this->numAvailableSlots($instance);
        $instance->completed = $this->hasBeenCompleted($instance);

        // Preload relationships
        $instance->author = Users::findPreloaded($instance->author_id);
        $instance->ministry = Ministries::findForTask($instance);
        $instance->organization = Organizations::findForTask($instance);
        $instance->department = OrganizationDepartments::findForTask($instance);
        $instance->status = TaskStatuses::findForTask($instance);
        $instance->category = TaskCategories::findForTask($instance);
        $instance->seniority = TaskSeniorities::findForTask($instance);
        $instance->skills = Skills::getAllForTask($instance);
        $instance->users = $this->getAssignedUsers($instance);
        $instance->reports = TaskProgressReports::getAllForTask($instance);
        $instance->outstanding_reports = TaskProgressReports::getAllOutstandingForTask($instance);
        $instance->has_outstanding_reports = count($instance->outstanding_reports) > 0;
        $instance->has_unread_reviews = $this->hasUnreadReviews($instance->outstanding_reports);
        $instance->tags = Tags::getAllForTask($instance);
        
        // Preload image
        $instance->header_image_url = asset($instance->header_image_url);

        // Get relationship counts for view task page (sidebar)
        $instance->num_reviews = $this->getNumReviews($instance);
        $instance->num_comments = $this->getNumComments($instance);
        $instance->num_progress_reports = $this->getNumProgressReports($instance);

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

    public function countAll()
    {
        return $this->getAll()->count();
    }

    public function createFromRequest(CreateTaskRequest $request)
    {
        // Grab the "open" task status
        $open = TaskStatuses::findByName("open");

        // Grab the selected category by it's name
        $category = TaskCategories::findOrCreateByName($request->task_category);

        // Compose the task data (with static properties)
        $data = [
            "project_id" => $request->project_id,
            "author_id" => Auth::user()->id,
            "task_status_id" => $open->id,
            "task_category_id" => $category->id,
            "task_seniority_id" => $request->task_seniority_id,
            "title" => $request->title,
            "description" => $request->description,
            "complexity" => $request->complexity,
            "estimated_hours" => $request->estimated_hours,
            "urgency" => $request->urgency,
            "ends_at" => $request->has("ends_at") ? Dates::parse($request->ends_at, "-")->format("Y-m-d") : null,
            "has_deadline" => (bool) $request->has_deadline,
        ];

        // Upload header image if one was uploaded
        if ($request->hasFile("header_image"))
        {
            $data["header_image_url"] = Uploader::upload($request->file("header_image"), "images/tasks/header");
        }

        // Process ownerships relationships
        if ($request->has("ministry_id") && intval($request->ministry_id) > 0) {
            $data["ministry_id"] = $request->ministry_id;
            if ($request->has("organization_id") && intval($request->organization_id) > 0) {
                $organization = Organizations::find($request->organization_id);
                if ($organization) {
                    $data["organization_id"] = $request->organization_id;
                    if ($request->has("department") && $request->department != "") {
                        $department = OrganizationDepartments::findOrCreateByName($organization, $request->department);
                        if ($department) {
                            $data["organization_department_id"] = $department->id;
                        }
                    }
                }
            }
        }

        // Create the task
        $task = Task::create($data);
        
        // Process task's skills & tags
        $this->processTaskSkills($task, $request->required_skills);
        $this->processTaskTags($task, $request->tags);

        // Fire events
        event(new TaskCreated($task));
        event(new UserCreatedTask(auth()->user(), $task));
        
        // Return the created task
        return $task;
    }

    public function updateFromRequest(Task $task, UpdateTaskRequest $request)
    {
        // Grab (or create) the selected task category
        $category = TaskCategories::findOrCreateByName($request->task_category);
        
        // Process ownerships relationships
        if ($request->has("ministry_id") && intval($request->ministry_id) > 0) {
            $task->ministry_id = $request->ministry_id;
            $organization = Organizations::find($request->organization_id);
            if ($request->has("organization_id") && intval($request->organization_id) > 0 && $organization) {
                $task->organization_id = $request->organization_id;
                if ($request->has("department") && $request->department != "") {
                    $department = OrganizationDepartments::findOrCreateByName($organization, $request->department);
                    if ($department) {
                        $task->organization_department_id = $department->id;
                    } else {
                        $task->organization_department_id = null;
                    }
                } else {
                    $task->organization_department_id = null;
                }
            } else {
                $task->organization_id = null;
                $task->organization_department_id = null;
            }
        } else {
            $task->ministry_id = null;
            $task->organization_id = null;
            $task->organization_department_id = null;
        }

        // Update the task's properties
        $task->task_category_id = $category->id;
        $task->project_id = $request->project_id;
        $task->task_status_id = $request->task_status_id;
        $task->task_seniority_id = $request->task_seniority_id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->complexity = $request->complexity;
        $task->estimated_hours = $request->estimated_hours;
        $task->realized_hours = is_null($request->realized_hours) ? 0 : $request->realized_hours;
        $task->urgency = $request->urgency;
        $task->has_deadline = (bool) $request->has_deadline;
        $task->ends_at = $request->has("ends_at") ? Dates::parse($request->ends_at, "-")->format("Y-m-d") : null;

        // Upload header image if one was uploaded
        if ($request->hasFile("header_image"))
        {
            $task->header_image_url = Uploader::upload($request->file("header_image"), "images/tasks/header");
        }

        // Save the changes made
        $task->save();

        // Update the task's relationships
        $this->processTaskSkills($task, $request->required_skills);
        $this->processTaskTags($task, $request->tags);

        // Fire events
        event(new TaskUpdated($task));
        event(new UserUpdatedTask(auth()->user(), $task));

        // Return the updated task
        return $task;
    }
    
    private function processTaskSkills(Task $task, $encodedSkills)
    {
        $skills = json_decode($encodedSkills);
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

    private function processTaskTags(Task $task, $encodedTags)
    {
        $tagNames = json_decode($encodedTags);
        if (is_array($tagNames) && count($tagNames))
        {
            $tag_ids = [];

            foreach ($tagNames as $name)
            {
                $tag = Tags::findOrCreateByName($name);
                if ($tag)
                {
                    $tag_ids[] = $tag->id;
                }
            }

            $task->tags()->sync($tag_ids);
        }
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

    public function unassignUser(Task $task, string $reason = null, User $user = null)
    {
        // Grab logged in user if no user was provided
        if (is_null($user)) $user = auth()->user();

        // Detach the user from the task
        $task->users()->detach($user->id);

        // Grab a fresh instance of the task
        $task = Task::find($task->id);

        // If this task now has no more assigned users while it was in progress
        if ($this->hasNoAssignedUsers($task) and $this->hasStatus($task, "in_progress"))
        {
            // Revert the status of the task back to open
            $this->updateStatus($task, "open");
        }

        // Send a message to the owner stating what happened
        $subject = __("tessify-core::tasks.abandon_message_subject", [
            "user" => $user->formatted_name,
            "title" => $task->title,
        ]);
        $message = __("tessify-core::tasks.abandon_message_text", [
            "user" => $user->formatted_name,
            "title" => $task->title,
            "reason" => is_null($reason) ? 
                __("tessify-core::tasks.abandon_message_no_reason") : 
                __("tessify-core::tasks.abandon_message_reason", [
                    "reason" => $reason,
                ]),
        ]);
        Messages::sendMessage($task->author, $subject, $message);
        // TODO: Make this a custom message & render the subject & text dynamically based on the user's locale
        // now the localized message is stored in the database. User won't notice until they switch locales.

        // Return the updated task
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
        // Calculate total number of hours spend on this task
        $totalHours = 0;
        foreach ($task->progressReports as $report)
        {
            $totalHours += $report->hours;
        }
        $task->realized_hours = $totalHours;

        // Update the task's status to completed
        $completedStatus = TaskStatuses::findByName("completed");
        if ($completedStatus)
        {
            $task->task_status_id = $completedStatus->id;
        }

        // Save changes made to the task
        $task->save();

        // Created 'CompletedTask' records for all of the assigned users
        foreach ($task->users as $user)
        {
            CompletedTasks::create($task, $user);
        }
        
        // Detaching the users is performed in the TaskEventSubscriber in a listener
        // That way we know which users completed the task so rewards can be rewarded
        // before detaching all users from the completed task
        
        // Fire events
        event(new TaskCompleted($task));

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

    public function getNumComments(Task $task)
    {
        return $task->comments()->count();
    }

    public function getNumReviews(Task $task)
    {
        // Grab logged in user
        $user = auth()->user();

        // If the user is the admin or author of the task
        if ($user->is_admin || $task->author->id == $user->id)
        {
            // Return the count of all reviews
            return $task->reviews->count();
        }
        // Otherwise
        else
        {
            // Return the count of all public reviews
            $out = 0;
            foreach ($task->reviews as $review)
            {
                if ($review->public)
                {
                    $out += 1;
                }
            }
            return $out;
        }
    }

    public function getNumProgressReports(Task $task)
    {
        return $task->progressReports->count();
    }
}