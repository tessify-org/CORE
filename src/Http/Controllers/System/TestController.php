<?php

namespace Tessify\Core\Http\Controllers\System;

use Search;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function getTestSearch($query)
    {
        $results = Search::search($query);
        dd($results);
    }
}