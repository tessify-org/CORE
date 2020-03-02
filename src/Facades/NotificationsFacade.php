<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class NotificationsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "notifications";
    }
}