<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class TaskSenioritiesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "task-seniorities";
    }
}