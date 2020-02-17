<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class TeamMemberApplicationsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "team-member-applications";
    }
}