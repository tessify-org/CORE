<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class TaskCategoriesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "task-categories";
    }
}