<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class MessagesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "messages";
    }
}