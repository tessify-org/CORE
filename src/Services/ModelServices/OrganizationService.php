<?php

namespace Tessify\Core\Services\ModelServices;

use Ministries;
use OrganizationTypes;
use OrganizationLocations;
use OrganizationDepartments;
use Tessify\Core\Models\Task;
use Tessify\Core\Models\Project;
use Tessify\Core\Models\Ministry;
use Tessify\Core\Models\Organization;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Organizations\CreateOrganizationRequest;
use Tessify\Core\Http\Requests\Organizations\UpdateOrganizationRequest;
use Tessify\Core\Http\Requests\Api\Organizations\CreateOrganizationRequest as ApiCreateRequest;
use Tessify\Core\Http\Requests\Api\Organizations\UpdateOrganizationRequest as ApiUpdateRequest;

class OrganizationService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\Organization";
    }
    
    public function preload($instance)
    {
        $instance->ministry = Ministries::find($instance->ministry_id);
        $instance->type = OrganizationTypes::find($instance->organization_type_id);
        $instance->locations = OrganizationLocations::findAllForOrganization($instance);
        $instance->departments = OrganizationDepartments::findAllForOrganization($instance);

        return $instance;
    }

    public function findAllForMinistry(Ministry $ministry)
    {
        $out = [];

        foreach ($this->getAll() as $organization)
        {
            if ($organization->ministry_id == $ministry->id)
            {
                $out[] = $organization;
            }
        }

        return $out;
    }

    public function findOrCreateByName($name)
    {
        foreach ($this->getAll() as $organization)
        {
            if ($organization->name == $name)
            {
                return $organization;
            }
        }
        
        return Organization::create([
            "name" => $name
        ]);
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
        foreach ($this->getAll() as $organization)
        {
            if ($organization->id == $project->organization_id)
            {
                return $organization;
            }
        }

        return false;
    }

    public function findForTask(Task $task)
    {
        foreach ($this->getAll() as $organization)
        {
            if ($organization->id == $task->organization_id)
            {
                return $organization;
            }
        }
    }
}