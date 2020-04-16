<?php

namespace Tessify\Core\Http\Controllers\Community;

use Auth;
use Organizations;
use App\Http\Controllers\Controller;

class OrganizationController extends Controller
{
    public function getOverview()
    {
        return view("tessify-core::pages.community.organizations.overview", [
            "organizations" => Organizations::getAll(),
        ]);
    }

    public function getView($slug)
    {
        $organization = Organizations::findBySlug($slug);
        if (!$organization)
        {
            flash(__("tessify-core::organizations.not_found"))->error();
            return redirect()->route("organizations");       
        }
        
        return view("tessify-core::pages.community.organizations.view", [
            "organization" => $organization,
        ]);
    }

    public function getSubscribe($slug)
    {
        $organization = Organizations::findBySlug($slug);
        if (!$organization)
        {
            flash(__("tessify-core::organizations.not_found"))->error();
            return redirect()->route("organizations");       
        }

        Auth::user()->subscribe($organization);

        flash(__("tessify-core::organizations.view_subscribed"))->success();
        return redirect()->route("organizations.view", ["slug" => $organization->slug]);
    }

    public function getUnsubscribe($slug)
    {
        $organization = Organizations::findBySlug($slug);
        if (!$organization)
        {
            flash(__("tessify-core::organizations.not_found"))->error();
            return redirect()->route("organizations");       
        }

        Auth::user()->unsubscribe($organization);

        flash(__("tessify-core::organizations.view_unsubscribed"))->success();
        return redirect()->route("organizations.view", ["slug" => $organization->slug]);
    }
}