<?php

namespace Tessify\Core\Http\Controllers\Community;

use Ministries;
use App\Http\Controllers\Controller;

class MinistryController extends Controller
{
    public function getOverview()
    {
        return view("tessify-core::pages.community.ministries.overview", [
            "ministries" => Ministries::getAll(),
        ]);
    }

    public function getView($slug)
    {
        $ministry = Ministries::findBySlug($slug);
        if (!$ministry)
        {
            flash(__("tessify-core::ministries.not_found"))->error();
            return redirect()->route("ministries");
        }

        return view("tessify-core::pages.community.ministries.view", [
            "ministry" => $ministry,
        ]);
    }
}