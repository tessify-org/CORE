<?php

namespace Tessify\Core\Http\Controllers\System;

use Search;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Search\SearchRequest;

class SearchController extends Controller
{
    public function getSearch()
    {
        return view("tessify-core::pages.system.search.search", [

        ]);
    }

    public function postSearch(SearchRequest $request)
    {
        $results = Search::search($request->search_query);

        return view("tessify-core::pages.system.search.search", [
            "query" => $request->search_query,
            "results" => $results,
        ]);
    }
}