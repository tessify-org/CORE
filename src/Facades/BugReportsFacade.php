<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class BugReportsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "bug-reports";
    }
}