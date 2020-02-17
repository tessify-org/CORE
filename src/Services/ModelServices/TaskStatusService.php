<?php

namespace Tessify\Core\Services\ModelServices;

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
}