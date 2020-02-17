<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class TeamRolesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "team-roles";
    }
}