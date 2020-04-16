<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class FeedActivitiesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "feed-activities";
    }
}