<?php

namespace Tessify\Core\Services\ModelServices;

use Auth;
use Users;
use Tasks;
use Projects;
use Exception;

use App\Models\User;
use Tessify\Core\Models\Task;
use Tessify\Core\Models\Project;
use Tessify\Core\Models\Comment;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Api\Comments\CreateCommentRequest;
use Tessify\Core\Http\Requests\Api\Comments\UpdateCommentRequest;

class CommentService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\Comment";
    }

    public function preload($instance)
    {
        $instance->user = Users::findPreloaded($instance->user_id);
        $instance->formatted_created_at = $instance->created_at->format("d-m-Y H:m:s");
        
        return $instance;
    }
    
    public function getAllPreloadedForProject(Project $job)
    {
        $out = [];

        foreach ($this->getAllPreloaded() as $comment)
        {
            if ($comment->commentable_type == "App\\Models\\Project" and $comment->commentable_id == $project->id)
            {
                $out[] = $comment;
            }
        }

        return collect($out);
    }

    public function getAllPreloadedForUser(User $user)
    {
        $out = [];

        foreach ($this->getAllPreloaded() as $comment)
        {
            if ($comment->commentable_type == "App\\Models\\User" and $comment->commentable_id == $user->id)
            {
                $out[] = $comment;
            }
        }

        return collect($out);
    }

    public function getAllPreloadedForTask(Task $task)
    {
        $out = [];

        foreach ($this->getAllPreloaded() as $comment)
        {
            if ($comment->commentable_type == "App\\Models\\Task" and $comment->commentable_id == $task->id)
            {
                $out[] = $comment;
            }
        }

        return collect($out);
    }

    public function createFromApiRequest(CreateCommentRequest $request)
    {
        // Convert the target type to a namespaced classname and validate at the same time
        $target_type = null;
        switch ($request->target_type)
        {
            case "project":
                $target_type = "App\\Models\\Project";
                $project = Projects::find($request->target_id);
                if (!$project) throw new Exception("Invalid job id received.");
            break;
            case "user":
                $target_type = "App\\Models\\User";
                $user = Users::find($request->target_id);
                if (!$user) throw new Exception("Invalid user id received.");
            break;
            case "task":
                $target_type = "App\\Models\\Task";
                $task = Tasks::find($request->target_id);
                if (!$task) throw new Exception("Invalid task id received");
            break;
        }
        if (is_null($target_type)) throw new Exception("Invalid target type received.");

        // TODO: add validation to make sure user can comment on the target? (only if applicable to final concept)

        // Create and return the comment
        $comment = Comment::create([
            "commentable_id" => $request->target_id,
            "commentable_type" => $target_type,
            "user_id" => Auth::user()->id,
            "body" => $request->comment,
        ]);

        // Return preloaded version of the comment
        return $this->preload($comment);
    }

    public function updateFromApiRequest(UpdateCommentRequest $request)
    {
        // Grab the comment
        $comment = $this->find($request->comment_id);

        // TODO: add validation to make sure comment belongs to logged in user

        // Update the body of the comment and save the changes
        $comment->body = $request->comment;
        $comment->save();

        // Return preloaded version of the updated comment
        return $this->preload($comment);
    }
}