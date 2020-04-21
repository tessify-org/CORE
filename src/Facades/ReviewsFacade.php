<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class ReviewsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "reviews";
    }
}