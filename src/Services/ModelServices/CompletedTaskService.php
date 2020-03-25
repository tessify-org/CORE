<?php

namespace Tessify\Core\Services\ModelServices;

use Auth;
use App\Models\User;
use Tessify\Core\Models\Task;
use Tessify\Core\Models\CompletedTask;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;

class CompletedTaskService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\CompletedTask";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function create(Task $task, User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        return CompletedTask::create([
            "user_id" => $user->id,
            "task_id" => $task->id,
        ]);
    }
}