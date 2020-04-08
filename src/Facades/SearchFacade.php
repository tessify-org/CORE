<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class SearchFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "search";
    }
}