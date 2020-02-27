<?php

namespace Tessify\Core\Services\ModelServices;

use OrganizationTypes;
use OrganizationLocations;
use OrganizationDepartments;
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
}