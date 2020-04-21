<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class ReviewRequestsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "review-requests";
    }
}