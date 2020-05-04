<?php

namespace Tessify\Core\Services\ModelServices;

use App\Models\User;
use Tessify\Core\Models\Task;
use Tessify\Core\Models\Project;
use Tessify\Core\Models\ReviewRequest;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;

class ReviewRequestService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\ReviewRequest";
    }
    
    public function preload($instance)
    {
        $instance->formatted_date = $instance->created_at->format("d-m-Y H:m:s");
        
        switch ($instance->reviewrequestable_type)
        {
            case "App\\Models\\User":
                $instance->formatted_type = __("tessify-core::reviews.type_user");
                $instance->formatted_name = $instance->reviewrequestable->formatted_name;
                $instance->target_href = route("profile", $instance->reviewrequestable->slug);
            break;
            
            case "Tessify\\Core\\Models\\Task":
                $instance->formatted_type = __("tessify-core::reviews.type_task");
                $instance->formatted_name = $instance->reviewrequestable->title;
                $instance->target_href = route("tasks.view", $instance->reviewrequestable->slug);
            break;

            case "Tessify\\Core\\Models\\Project":
                $instance->formatted_type = __("tessify-core::reviews.type_project");
                $instance->formatted_name = $instance->reviewrequestable->title;
                $instance->target_href = route("projects.view", $instance->reviewrequestable->slug);
            break;
        }
        
        $instance->accept_href = route("reviews.requests.accept", ["uuid" => $instance->uuid]);
        $instance->reject_href = route("reviews.requests.reject", ["uuid" => $instance->uuid]);

        return $instance;
    }

    public function findByUuid($uuid)
    {
        foreach ($this->getAll() as $request)
        {
            if ($request->uuid == $uuid)
            {
                return $request;
            }
        }

        return false;
    }

    public function findPreloadedByUuid($uuid)
    {
        foreach ($this->getAllPreloaded() as $request)
        {
            if ($request->uuid == $uuid)
            {
                return $request;
            }
        }

        return false;
    }

    public function getMyRequests(User $user = null)
    {
        if (is_null($user)) $user = auth()->user();
        
        $out = [];

        foreach ($this->getAllPreloaded() as $request)
        {
            if ($request->user_id == auth()->user()->id && $request->status == "open")
            {
                $out[] = $request;
            }
        }

        return collect($out);
    }

    public function numRequests(User $user = null)
    {
        return $this->getMyRequests($user)->count();
    }

    public function createForUser(User $user, $reason, User $targetUser = null)
    {
        if (is_null($targetUser)) $targetUser = auth()->user();

        return ReviewRequest::create([
            "user_id" => $targetUser->id,
            "reviewrequestable_type" => get_class($user),
            "reviewrequestable_id" => $user->id,
            "reason" => $reason,
        ]);
    }

    public function createForTask(Task $task, string $reason, User $targetUser = null)
    {
        if (is_null($targetUser)) $targetUser = auth()->user();

        return ReviewRequest::create([
            "user_id" => $targetUser->id,
            "reviewrequestable_type" => get_class($task),
            "reviewrequestable_id" => $task->id,
            "reason" => $reason,
        ]);
    }

    public function createForProject(Project $project, string $reason, User $targetUser = null)
    {
        if (is_null($targetUser)) $targetUser = auth()->user();
        
        return ReviewRequest::create([
            "user_id" => $targetUser->id,
            "reviewrequestable_type" => get_class($project),
            "reviewrequestable_id" => $project->id,
            "reason" => $reason,
        ]);
    }

    public function reject(ReviewRequest $reviewRequest)
    {
        $reviewRequest->status = "rejected";
        $reviewRequest->save();

        return $reviewRequest;
    }

    public function flagAsFulfilled(ReviewRequest $reviewRequest)
    {
        $reviewRequest->status = "fulfilled";
        $reviewRequest->save();

        return $reviewRequest;
    }

    public function completeOutstandingRequestFor($type, $slug)
    {
        $className = $this->convertTypeToClassName($type, $slug);
        if ($className)
        {
            $target = $className::where("slug", $slug)->first();
            if ($target)
            {
                $requests = ReviewRequest::where("user_id", auth()->user()->id)
                                         ->where("reviewrequestable_type", $className)
                                         ->where("reviewrequestable_id", $target->id)
                                         ->where("status", "open")
                                         ->get();
                
                if ($requests->count())
                {
                    foreach ($requests as $request)
                    {
                        $this->flagAsFulfilled($request);
                    }
                }
            }
        }
    }

    private function convertTypeToClassName($type)
    {
        switch ($type)
        {
            case "user":
                return "Tessify\\Core\\Models\\User";
            break;

            case "task":
                return "Tessify\\Core\\Models\\Task";
            break;

            case "project":
                return "Tessify\\Core\\Models\\Project";
            break;
        }

        return false;
    }

    public function hasOutstandingRequestsFor($instance)
    {
        foreach ($this->getAll() as $request)
        {
            
            if ($request->reviewrequestable_type == get_class($instance) && $request->reviewrequestable_id == $instance->id && $request->status == "open")
            {
                return true;
            }
        }

        return false;
    }
}