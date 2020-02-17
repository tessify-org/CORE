<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class TasksFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "tasks";
    }
}