<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class ReputationFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "reputation";
    }
}