<?php

namespace Tessify\Core\Services\ModelServices;

use Tessify\Core\Models\Task;
use Tessify\Core\Models\Project;
use Tessify\Core\Models\TaskCategory;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;

class TaskCategoryService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\TaskCategory";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function findForTask(Task $task)
    {
        foreach ($this->getAll() as $category)
        {
            if ($category->id == $task->task_category_id)
            {
                return $category;
            }
        }

        return false;
    }
}