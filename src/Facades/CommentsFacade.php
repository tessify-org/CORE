<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class CommentsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "comments";
    }
}