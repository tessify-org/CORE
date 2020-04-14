<?php

namespace Tessify\Core\Http\Controllers\Community;

use App\Http\Controllers\Controller;

class CommunityController extends Controller
{
    public function getOverview()
    {
        return view("tessify-core::pages.community.overview", []);
    }
}