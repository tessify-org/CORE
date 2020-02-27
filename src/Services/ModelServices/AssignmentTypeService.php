<?php

namespace Tessify\Core\Services\ModelServices;

use Tessify\Core\Models\AssignmentType;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Assignments\Types\CreateAssignmentTypeRequest;
use Tessify\Core\Http\Requests\Assignments\Types\UpdateAssignmentTypeRequest;
use Tessify\Core\Http\Requests\Api\Assignments\Types\CreateAssignmentTypeRequest as ApiCreateRequest;
use Tessify\Core\Http\Requests\Api\Assignments\Types\UpdateAssignmentTypeRequest as ApiUpdateRequest;

class AssignmentTypeService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\AssignmentType";
    }
    
    public function preload($instance)
    {
        return $instance;
    }
}