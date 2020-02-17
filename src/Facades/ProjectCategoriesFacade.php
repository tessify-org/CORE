<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class ProjectCategoriesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "project-categories";
    }
}