<?php

namespace Tessify\Core\Http\Controllers\Community;

use Organizations;
use App\Http\Controllers\Controller;

class OrganizationController extends Controller
{
    public function getOverview()
    {
        return view("tessify-core::pages.organizations.overview", [
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
        
        return view("tessify-core::pages.organizations.view", [
            "organization" => $organization,
        ]);
    }
}