<?php

namespace Tessify\Core\Services\ModelServices;

use Tessify\Core\Models\Task;
use Tessify\Core\Models\Project;
use Tessify\Core\Models\TaskSeniority;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;

class TaskSeniorityService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\TaskSeniority";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function findForTask(Task $task)
    {
        foreach ($this->getAll() as $seniority)
        {
            if ($seniority->id == $task->task_seniority_id)
            {
                return $seniority;
            }
        }

        return false;
    }
}