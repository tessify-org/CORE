<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class AssignmentTypesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "assignment-types";
    }
}