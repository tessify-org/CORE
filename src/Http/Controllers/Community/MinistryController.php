<?php

namespace Tessify\Core\Http\Controllers\Community;

use Auth;
use Ministries;
use App\Http\Controllers\Controller;
use Tessify\Core\Events\Users\UserSubscribedMinistry;
use Tessify\Core\Events\Users\UserUnsubscribedMinistry;

class MinistryController extends Controller
{
    public function getOverview()
    {
        // Render the ministry overview page
        return view("tessify-core::pages.community.ministries.overview", [
            "ministries" => Ministries::getAll(),
        ]);
    }

    public function getView($slug)
    {
        // Grab the ministry we want to view
        $ministry = Ministries::findBySlug($slug);
        if (!$ministry)
        {
            flash(__("tessify-core::ministries.not_found"))->error();
            return redirect()->route("ministries");
        }

        // Render the view ministry page
        return view("tessify-core::pages.community.ministries.view", [
            "ministry" => $ministry,
        ]);
    }

    public function getSubscribe($slug)
    {
        // Grab the ministry we want to subscribe to
        $ministry = Ministries::findBySlug($slug);
        if (!$ministry)
        {
            flash(__("tessify-core::ministries.not_found"))->error();
            return redirect()->route("ministries");
        }

        // Subscribe the user to the ministry
        Auth::user()->subscribe($ministry);

        // Fire event
        event(new UserSubscribedMinsitry(auth()->user(), $ministry));

        // Flash message & redirect to view ministry page
        flash(__("tessify-core::ministries.view_subscribed"))->success();
        return redirect()->route("ministries.view", ["slug" => $ministry->slug]);

    }

    public function getUnsubscribe($slug)
    {
        // Grab the ministry we want to unsubscribe from
        $ministry = Ministries::findBySlug($slug);
        if (!$ministry)
        {
            flash(__("tessify-core::ministries.not_found"))->error();
            return redirect()->route("ministries");
        }

        // Unsubscribe the user from the ministry
        Auth::user()->unsubscribe($ministry);

        // Fire event
        event(new UserUnsubscribedMinistry(auth()->user(), $ministry));

        // Flash message & redirect to view ministry page
        flash(__("tessify-core::ministries.view_unsubscribed"))->success();
        return redirect()->route("ministries.view", ["slug" => $ministry->slug]);
        
    }
}