<?php

namespace Tessify\Core\Http\Controllers\Projects;

use Projects;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Projects\Teams\InviteTeamMemberRequest;
use Tessify\Core\Http\Requests\Projects\Teams\ApplyForTeamRoleRequest;

class ProjectTeamController extends Controller
{
    public function getView($slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        return view("tessify-core::pages.projects.team", [
            "project" => $project,
        ]);
    }

    public function getApply($slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }
        
        return view("tessify-core::pages.projects.teams.apply", [
            "project" => $project,
        ]);
    }

    public function postApply(ApplyForTeamRoleRequest $request, $slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

    }

    public function getRemoveMember($slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }
        
        return view("tessify-core::pages.projects.teams.remove-member", [
            "project" => $project,
            
        ])
    }

    public function postRemoveMember(RemoveMemberFromTeamRequest $request, $slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

    }

    public function getInvite($slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

    }

    public function postInvite(InviteTeamMemberRequest $request, $slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

    }
}