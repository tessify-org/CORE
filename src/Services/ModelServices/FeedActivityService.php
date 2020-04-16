<?php

namespace Tessify\Core\Services\ModelServices;

use Auth;
use Tasks;
use Users;
use Projects;
use App\Models\User;
use Tessify\Core\Models\FeedActivity;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;

class FeedActivityService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\FeedActivity";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function create($name, $target, User $actor = null, array $data = null, User $user = null)
    {
        // Grab the current user if no user was provided
        if (is_null($user)) $user = Auth::user();

        // Create & return an activity feed entry
        return FeedActivity::create([
            "user_id" => $user->id,
            "actor_id" => !is_null($actor) ? $actor->id : null,
            "target_type" => get_class($target),
            "target_id" => $target->id,
            "name" => $name,
            "data" => $data,
        ]);
    }

    public function getFeed(User $user = null)
    {
        // Grab the current user if no user was provided
        if (is_null($user)) $user = Auth::user();

        // Gather all of the user's activity feed entries
        $out = [];
        foreach ($this->getAll() as $activity)
        {
            if ($activity->user_id == $user->id)
            {
                $text = $this->composeActivityText($activity);
                if ($text)
                {
                    $out[] = [
                        "data" => $activity,
                        "text" => $text,
                        "formatted_date" => $activity->created_at->format("d-m-Y H:m:s"),
                    ];
                }
            }
        }

        // Convert the output to a Collection
        $out = collect($out);

        // Return the output sorted by their creation date (high to low)
        return $out->sortByDesc("created_at");
    }

    public function composeActivityText(FeedActivity $activity)
    {
        switch ($activity->name)
        {
            case "user_created_task":
                $task = Tasks::find($activity->target_id);
                if ($task) return __("tessify-core::activity-feed.user_created_task", ["name" => $activity->actor->formatted_name, "title" => $task->title]);
            break;
            case "user_updated_task":
                $task = Tasks::find($activity->target_id);
                if ($task) return __("tessify-core::activity-feed.user_updated_task", ["name" => $activity->actor->formatted_name, "title" => $task->title]);
            break;
            case "user_followed_task":
                $task = Tasks::find($activity->target_id);
                if ($task) return __("tessify-core::activity-feed.user_followed_task", ["name" => $activity->actor->formatted_name, "title" => $task->title]);
            break;
            case "user_created_project":
                $project = Projects::find($activity->target_id);
                if ($project) return __("tessify-core::activity-feed.user_created_project", ["name" => $activity->actor->formatted_name, "title" => $project->title]);
            break;
            case "user_updated_project":
                $project = Projects::find($activity->target_id);
                if ($project) return __("tessify-core::activity-feed.user_updated_project", ["name" => $activity->actor->formatted_name, "title" => $project->title]);
            break;
            case "user_followed_project":
                $project = Projects::find($activity->target_id);
                if ($project) return __("tessify-core::activity-feed.user_followed_project", ["name" => $activity->actor->formatted_name, "title" => $project->title]);
            break;
            case "user_followed_user":
                $targetUser = Users::find($activity->target_id);
                if ($targetUser) return __("tessify-core::activity-feed.user_followed_user", ["name" => $activity->actor->formatted_name, "user_name" => $targetUser->formatted_name]);
            break;
            case "user_commented":
                // TODO
            break;
            case "task_updated":
                $task = Tasks::find($activity->target_id);
                if ($task) return __("tessify-core::activity-feed.task_updated", ["title" => $task->title]);
            break;
            case "task_completed":
                $task = Tasks::find($activity->target_id);
                if ($task) return __("tessify-core::activity-feed.task_completed", ["title" => $task->title]);
            break;
            case "project_updated":
                $project = Projects::find($activity->target_id);
                if ($project) return __("tessify-core::activity-feed.project_updated", ["title" => $project->title]);
            break;
            case "project_deleted":
                $project = Projects::find($activity->target_id);
                if ($project) return __("tessify-core::activity-feed.project_deleted", ["title" => $project->title]);
            break;
            case "project_completed":
                $project = Projects::find($activity->target_id);
                if ($project) return __("tessify-core::activity-feed.project_completed", ["title" => $project->title]);
            break;
        }

        // Return false if we did not recognize the activity or we failed to retrieve
        // any of the data during the composing of the text to output.
        return false;
    }
}