<?php

namespace Tessify\Core\Http\Controllers\System;

use App\Http\Controllers\Controller;

class StaticPageController extends Controller
{
    public function getDontUseInternetExplorer()
    {
        return view("tessify-core::pages.static.dont-use-ie");
    }
}