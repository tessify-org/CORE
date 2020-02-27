<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class OrganizationDepartmentsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "organization-departments";
    }
}