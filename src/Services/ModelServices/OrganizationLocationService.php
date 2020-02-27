<?php

namespace Tessify\Core\Services\ModelServices;

use Tessify\Core\Models\Organization;
use Tessify\Core\Models\OrganizationLocation;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Organizations\Locations\CreateOrganizationLocationRequest;
use Tessify\Core\Http\Requests\Organizations\Locations\UpdateOrganizationLocationRequest;
use Tessify\Core\Http\Requests\Api\Organizations\Locations\UpdateOrganizationLocationRequest as ApiCreateRequest;
use Tessify\Core\Http\Requests\Api\Organizations\Locations\CreateOrganizationLocationRequest as ApiUpdateRequest;

class ProjectResourceService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\OrganizationLocation";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function findAllForOrganization(Organization $organization)
    {
        $out = [];

        foreach ($this->getAll() as $location)
        {
            if ($location->organization_id == $organization->id)
            {
                $out[] = $location;
            }
        }

        return $out;
    }
}