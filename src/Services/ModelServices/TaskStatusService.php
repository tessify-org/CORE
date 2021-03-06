<?php

namespace Tessify\Core\Services\ModelServices;

use Tessify\Core\Models\Task;
use Tessify\Core\Models\TaskStatus;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;

class TaskStatusService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\TaskStatus";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function findForTask(Task $task)
    {
        foreach ($this->getAll() as $status)
        {
            if ($status->id == $task->task_status_id)
            {
                return $status;
            }
        }

        return false;
    }

    public function findByName($name)
    {
        foreach ($this->getAll() as $status)
        {
            if ($status->name == $name)
            {
                return $status;
            }
        }

        return false;
    }
}