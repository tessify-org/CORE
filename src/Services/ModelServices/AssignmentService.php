<?php

namespace Tessify\Core\Services\ModelServices;

use Organizations;
use OrganizationTypes;
use OrganizationDepartments;
use Tessify\Core\Models\Assignment;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Assignments\CreateAssignmentRequest;
use Tessify\Core\Http\Requests\Assignments\UpdateAssignmentRequest;
use Tessify\Core\Http\Requests\Api\Assignments\CreateAssignmentRequest as ApiCreateRequest;
use Tessify\Core\Http\Requests\Api\Assignments\UpdateAssignmentRequest as ApiUpdateRequest;

class AssignmentService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\Assignment";
    }
    
    public function preload($instance)
    {
        $instance->type = OrganizationTypes::find($request->assignment_type_id);
        $instance->organization = Organizations::find($instance->organization_id);
        $instance->department = OrganizationDepartments::find($instance->organization_department_id);

        return $instance;
    }
}