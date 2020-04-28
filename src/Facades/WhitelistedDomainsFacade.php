<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class WhitelistedDomainsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "whitelisted-domains";
    }
}