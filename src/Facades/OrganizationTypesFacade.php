<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class OrganizationTypesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "organization-types";
    }
}