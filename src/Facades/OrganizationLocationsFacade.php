<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class OrganizationLocationsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "organization-locations";
    }
}