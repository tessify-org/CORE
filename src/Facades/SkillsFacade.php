<?php

namespace Tessify\Core\Facades;

use Illuminate\Support\Facades\Facade;

class SkillsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "skills";
    }
}