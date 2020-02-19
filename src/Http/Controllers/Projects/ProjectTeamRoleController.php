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
            "oldInput" => collect([
                "name" => old("name"),
                "description" => old("description"),
                "positions" => old("positions"),
            ])
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

        $this->authorize("manage-team-roles", $project);

        TeamRoles::createFromRequest($project, $request);

        flash(__("tessify-core::projects.create_role_succeeded"))->success();
        return redirect()->route("projects.team.view", $project->slug);
    }

    public function getUpdate($slug, $roleSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $teamRole = TeamRoles::findPreloadedBySlug($roleSlug);
        if (!$teamRole)
        {
            flash(__("tessify-core::projects.team_role_not_found"))->error();
            return redirect()->route("projects.team.view", $project->slug);
        }

        return view("tessify-core::pages.projects.teams.roles.edit", [
            "project" => $project,
            "teamRole" => $teamRole,
            "oldInput" => collect([
                "name" => old("name"),
                "description" => old("description"),
                "positions" => old("positions"),
            ])
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

        $this->authorize("manage-team-roles", $project);

        $teamRole = TeamRoles::findPreloadedBySlug($roleSlug);
        if (!$teamRole)
        {
            flash(__("tessify-core::projects.team_role_not_found"))->error();
            return redirect()->route("projects.team.view", $project->slug);
        }
        
        TeamRoles::updateFromRequest($teamRole, $request);

        flash(__("tessify-core::general.saved_changes"))->success();
        return redirect()->route("projects.team.view", $project->slug);
    }

    public function getDelete($slug, $roleSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $teamRole = TeamRoles::findPreloadedBySlug($roleSlug);
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

        $this->authorize("manage-team-roles", $project);

        $teamRole = TeamRoles::findPreloadedBySlug($roleSlug);
        if (!$teamRole)
        {
            flash(__("tessify-core::projects.team_role_not_found"))->error();
            return redirect()->route("projects.team.view", $project->slug);
        }
        
        $teamRole->delete();

        flash(__("tessify-core::projects.delete_role_succeeded"))->success();
        return redirect()->route("projects.team.view", $project->slug);
    }
}