<?php

namespace Tessify\Core\Http\Controllers\Projects;

use Projects;
use TeamRoles;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Projects\Teams\Roles\CreateTeamRoleRequest;
use Tessify\Core\Http\Requests\Projects\Teams\Roles\UpdateTeamRoleRequest;
use Tessify\Core\Http\Requests\Projects\Teams\Roles\DeleteTeamRoleRequest;

class ProjectTeamRoleController extends Controller
{
    public function getCreate($slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        return view("tessify-core::pages.projects.teams.roles.create", [
            "project" => $project,
        ]);
    }

    public function postCreate(CreateTeamRoleRequest $request, $slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        dd($request->all());
    }

    public function getUpdate($slug, $roleSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $teamRole = TeamRoles::findPreloadedBySlug($slug);
        if (!$teamRole)
        {
            flash(__("tessify-core::projects.team_role_not_found"))->error();
            return redirect()->route("projects.view", $project->slug);
        }

        return view("tessify-core::pages.projects.teams.roles.edit", [
            "project" => $project,
            "teamRole" => $teamRole,
        ]);
    }

    public function postUpdate(UpdateTeamRoleRequest $request, $slug, $roleSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $teamRole = TeamRoles::findPreloadedBySlug($slug);
        if (!$teamRole)
        {
            flash(__("tessify-core::projects.team_role_not_found"))->error();
            return redirect()->route("projects.view", $project->slug);
        }
        
        dd($request->all());
    }

    public function getDelete($slug, $roleSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $teamRole = TeamRoles::findPreloadedBySlug($slug);
        if (!$teamRole)
        {
            flash(__("tessify-core::projects.team_role_not_found"))->error();
            return redirect()->route("projects.view", $project->slug);
        }
        
        return view("tessify-core::pages.projects.teams.roles.delete", [
            "project" => $project,
            "teamRole" => $teamRole,
        ]);
    }

    public function postDelete(DeleteTeamRoleRequest $request, $slug, $roleSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $teamRole = TeamRoles::findPreloadedBySlug($slug);
        if (!$teamRole)
        {
            flash(__("tessify-core::projects.team_role_not_found"))->error();
            return redirect()->route("projects.view", $project->slug);
        }
        
    }
}