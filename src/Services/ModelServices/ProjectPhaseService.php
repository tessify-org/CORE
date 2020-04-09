<?php

namespace Tessify\Core\Services\ModelServices;

use Tessify\Core\Models\Project;
use Tessify\Core\Models\ProjectPhase;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;

class ProjectPhaseService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\ProjectPhase";
    }

    public function preload($instance)
    {
        return $instance;
    }

    public function findOrCreateByName($name)
    {
        foreach ($this->getAll() as $phase)
        {
            if ($phase->name == $name)
            {
                return $phase;
            }
        }

        return ProjectPhase::create(["name" => $name]);
    }

    public function findForProject(Project $project)
    {
        foreach ($this->getAllPreloaded() as $phase)
        {
            if ($phase->id == $project->project_phase_id)
            {
                return $phase;
            }
        }

        return false;
    }
}
    