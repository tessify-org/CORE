<?php

namespace Tessify\Core\Http\Controllers\Community;

use Auth;
use Organizations;
use OrganizationDepartments;
use App\Http\Controllers\Controller;
use Tessify\Core\Events\Users\UserSusbcribedOrganization;
use Tessify\Core\Events\Users\UserUnsusbcribedOrganization;

class OrganizationController extends Controller
{
    public function getOverview()
    {
        // Render the organization overview page
        return view("tessify-core::pages.community.organizations.overview", [
            "organizations" => Organizations::getAll(),
        ]);
    }

    public function getView($slug)
    {
        // Grab the organization we want to view
        $organization = Organizations::findBySlug($slug);
        if (!$organization)
        {
            flash(__("tessify-core::organizations.not_found"))->error();
            return redirect()->route("organizations");       
        }
        
        // Render the view organization page
        return view("tessify-core::pages.community.organizations.view", [
            "organization" => $organization,
        ]);
    }

    public function getSubscribe($slug)
    {
        // Grab the organization we want to subscribe to
        $organization = Organizations::findBySlug($slug);
        if (!$organization)
        {
            flash(__("tessify-core::organizations.not_found"))->error();
            return redirect()->route("organizations");       
        }

        // Subscribe the user to the organization
        Auth::user()->subscribe($organization);

        // Fire event
        event(new UserSubscribedOrganization(auth()->user(), $organization));

        // Flash message & redirect to the view organization page
        flash(__("tessify-core::organizations.view_subscribed"))->success();
        return redirect()->route("organizations.view", ["slug" => $organization->slug]);
    }

    public function getUnsubscribe($slug)
    {
        // Grab the organization we want to unsubscribe from
        $organization = Organizations::findBySlug($slug);
        if (!$organization)
        {
            flash(__("tessify-core::organizations.not_found"))->error();
            return redirect()->route("organizations");       
        }

        // Unsubscribe the user from the organization
        Auth::user()->unsubscribe($organization);

        // Fire event
        event(new UserUnsubscribedOrganization(auth()->user(), $organization));

        // Flash message & redirect to the view organization page
        flash(__("tessify-core::organizations.view_unsubscribed"))->success();
        return redirect()->route("organizations.view", ["slug" => $organization->slug]);
    }

    public function getViewDepartment($slug, $departmentSlug)
    {
        // Grab the organization we want to view a department of
        $organization = Organizations::findBySlug($slug);
        if (!$organization)
        {
            flash(__("tessify-core::organizations.not_found"))->error();
            return redirect()->route("organizations");       
        }

        // Grab the department we want to view
        $department = OrganizationDepartments::findBySlug($departmentSlug);
        if (!$department)
        {
            flash(__("tessify-core::organizations.department_not_found"));
            return redirect()->route("organizations.view", $slug);
        }

        // Render the view organization department page
        return view("tessify-core::pages.community.organizations.view-department", [
            "organization" => $organization,
            "department" => $department,
        ]);
    }
}