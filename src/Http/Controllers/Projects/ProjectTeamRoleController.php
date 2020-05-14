<?php

namespace Tessify\Core\Http\Controllers\Projects;

use Projects;
use TeamRoles;
use TeamMembers;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Projects\Teams\Roles\CreateTeamRoleRequest;
use Tessify\Core\Http\Requests\Projects\Teams\Roles\UpdateTeamRoleRequest;
use Tessify\Core\Http\Requests\Projects\Teams\Roles\DeleteTeamRoleRequest;

class ProjectTeamRoleController extends Controller
{
    public function getOverview($slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        return view("tessify-core::pages.projects.team.roles.overview", [
            "project" => $project,
            "roles" => collect(TeamRoles::getAllForProject($project)),
            "strings" => collect([
                "title" => __("tessify-core::projects.team_roles_title"),
                "no_records" => __("tessify-core::projects.team_roles_no_records"),
                "add_button" => __("tessify-core::projects.team_roles_add_button"),
                "view_title" => __("tessify-core::projects.team_roles_view_title"),
                "view_edit" => __("tessify-core::projects.team_roles_view_edit"),
                "view_delete" => __("tessify-core::projects.team_roles_view_delete"),
                "create_title" => __("tessify-core::projects.team_roles_create_title"),
                "create_cancel" => __("tessify-core::projects.team_roles_create_cancel"),
                "create_submit" => __("tessify-core::projects.team_roles_create_submit"),
                "update_title" => __("tessify-core::projects.team_roles_update_title"),
                "update_cancel" => __("tessify-core::projects.team_roles_update_cancel"),
                "update_submit" => __("tessify-core::projects.team_roles_update_submit"),
                "delete_title" => __("tessify-core::projects.team_roles_delete_title"),
                "delete_text" => __("tessify-core::projects.team_roles_delete_text"),
                "delete_cancel" => __("tessify-core::projects.team_roles_delete_cancel"),
                "delete_submit" => __("tessify-core::projects.team_roles_delete_submit"),
                "form_name" => __("tessify-core::projects.team_roles_form_name"),
                "form_description" => __("tessify-core::projects.team_roles_form_description"),
                "form_positions" => __("tessify-core::projects.team_roles_form_positions"),
            ]),
            "apiEndpoints" => collect([
                "create" => route("api.team-roles.create"),
                "update" => route("api.team-roles.update"),
                "delete" => route("api.team-roles.delete"),
            ]),
        ]);
    }

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
        
        TeamRoles::deleteRole($teamRole);

        flash(__("tessify-core::projects.delete_role_succeeded"))->success();
        return redirect()->route("projects.team.view", $project->slug);
    }

    public function getAssignToMe($slug, $roleSlug)
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
            return redirect()->route("projects.view", $project->slug);
        }
        
        TeamMembers::addUserToTeam($teamRole);

        flash(__("tessify-core::projects.view_team_assigned_to_self", ["name" => $teamRole->name]))->success();
        return redirect()->route("projects.team.view", $project->slug);
    }
}