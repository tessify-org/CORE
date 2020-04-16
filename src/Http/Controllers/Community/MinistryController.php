<?php

namespace Tessify\Core\Http\Controllers\Community;

use Auth;
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

    public function getSubscribe($slug)
    {
        $ministry = Ministries::findBySlug($slug);
        if (!$ministry)
        {
            flash(__("tessify-core::ministries.not_found"))->error();
            return redirect()->route("ministries");
        }

        Auth::user()->subscribe($ministry);

        flash(__("tessify-core::ministries.view_subscribed"))->success();
        return redirect()->route("ministries.view", ["slug" => $ministry->slug]);

    }

    public function getUnsubscribe($slug)
    {
        $ministry = Ministries::findBySlug($slug);
        if (!$ministry)
        {
            flash(__("tessify-core::ministries.not_found"))->error();
            return redirect()->route("ministries");
        }

        Auth::user()->unsubscribe($ministry);

        flash(__("tessify-core::ministries.view_unsubscribed"))->success();
        return redirect()->route("ministries.view", ["slug" => $ministry->slug]);
        
    }
}