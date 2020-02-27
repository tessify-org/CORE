<?php

namespace Tessify\Core\Services\ModelServices;

use Tessify\Core\Models\OrganizationType;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Organizations\Types\CreateOrganizationTypeRequest;
use Tessify\Core\Http\Requests\Organizations\Types\UpdateOrganizationTypeRequest;
use Tessify\Core\Http\Requests\Api\Organizations\Types\CreateOrganizationTypeRequest as ApiCreateRequest;
use Tessify\Core\Http\Requests\Api\Organizations\Types\UpdateOrganizationTypeRequest as ApiUpdateRequest;

class OrganizationTypeService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\OrganizationType";
    }
    
    public function preload($instance)
    {
        return $instance;
    }
}