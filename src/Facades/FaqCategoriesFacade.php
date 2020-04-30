<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class FaqCategoriesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "faq-categories";
    }
}