<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class ProjectResourcesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "project-resources";
    }
}