<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class MinistriesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "ministries";
    }
}