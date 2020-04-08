<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class NewslettersFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "newsletters";
    }
}