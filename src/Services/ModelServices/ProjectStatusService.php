<?php

namespace Tessify\Core\Services\ModelServices;

use Tessify\Core\Models\Project;
use Tessify\Core\Models\ProjectStatus;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;

class ProjectStatusService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\ProjectStatus";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function findForProject(Project $project)
    {
        foreach ($this->getAll() as $status)
        {
            if ($status->id == $project->project_status_id)
            {
                return $status;
            }
        }

        return false;
    }
}