<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class FaqsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "faqs";
    }
}