<?php

namespace Tessify\Core\Services\ModelServices;

use Tessify\Core\Models\Task;
use Tessify\Core\Models\Project;
use Tessify\Core\Models\Organization;
use Tessify\Core\Models\OrganizationDepartment;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Organizations\Departments\CreateDepartmentRequest;
use Tessify\Core\Http\Requests\Organizations\Departments\UpdateDepartmentRequest;
use Tessify\Core\Http\Requests\Api\Organizations\Departments\CreateDepartmentRequest as ApiCreateRequest;
use Tessify\Core\Http\Requests\Api\Organizations\Departments\UpdateDepartmentRequest as ApiUpdateRequest;

class OrganizationDepartmentService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\OrganizationDepartment";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function findAllForOrganization(Organization $organization)
    {
        $out = [];

        foreach ($this->getAll() as $department)
        {
            if ($department->organization_id == $organization->id)
            {
                $out[] = $department;
            }
        }

        return $out;
    }

    public function findOrCreateByName(Organization $organization, $name)
    {
        foreach ($this->getAll() as $department)
        {
            if ($department->organization_id == $organization->id and $department->name == $name)
            {
                return $department;
            }
        }

        return OrganizationDepartment::create([
            "organization_id" => $organization->id,
            "name" => $name,
        ]);
    }

    public function findForProject(Project $project)
    {
        foreach ($this->getAll() as $department)
        {
            if ($department->id == $project->organization_department_id)
            {
                return $department;
            }
        }
        
        return false;
    }

    public function findForTask(Task $task)
    {
        foreach ($this->getAll() as $department)
        {
            if ($department->id == $task->organization_department_id)
            {
                return $department;
            }
        }

        return false;
    }
}