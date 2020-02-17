<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class ProjectStatusesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "project-statuses";
    }
}