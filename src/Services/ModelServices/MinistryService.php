<?php

namespace Tessify\Core\Services\ModelServices;

use Organizations;
use Tessify\Core\Models\Task;
use Tessify\Core\Models\Project;
use Tessify\Core\Models\Ministry;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Ministries\CreateMinistryRequest;
use Tessify\Core\Http\Requests\Ministries\UpdateMinistryRequest;
use Tessify\Core\Http\Requests\Api\Ministries\CreateMinistryRequest as ApiCreateRequest;
use Tessify\Core\Http\Requests\Api\Ministries\UpdateMinistryRequest as ApiUpdateRequest;

class MinistryService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\Ministry";
    }
    
    public function preload($instance)
    {
        $instance->organizations = Organizations::findAllForMinistry($ministry);

        return $instance;
    }

    public function findBySlug($slug)
    {
        foreach ($this->getAll() as $organization)
        {
            if ($organization->slug == $slug)
            {
                return $organization;
            }
        }

        return false;
    }

    public function findForProject(Project $project)
    {
        foreach ($this->getAll() as $ministry)
        {
            if ($ministry->id === $project->ministry_id)
            {
                return $ministry;
            }
        }

        return false;
    }

    public function findForTask(Task $task)
    {
        foreach ($this->getAll() as $ministry)
        {
            if ($ministry->id == $task->ministry_id)
            {
                return $task;
            }
        }

        return false;
    }
}