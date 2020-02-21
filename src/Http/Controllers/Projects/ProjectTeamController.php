<?php

namespace Tessify\Core\Http\Controllers\Projects;

use Users;
use Projects;
use TeamMembers;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Projects\Teams\LeaveTeamRequest;
use Tessify\Core\Http\Requests\Projects\Teams\UpdateTeamMemberRolesRequest;
use Tessify\Core\Http\Requests\Projects\Teams\Applications\InviteTeamMemberRequest;

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

        return view("tessify-core::pages.projects.teams.view", [
            "project" => $project,
            "user" => Users::current(),
            "outstandingRoles" => Projects::getOutstandingRoles($project),
        ]);
    }

    public function getLeaveTeam($slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        return view("tessify-core::pages.projects.teams.leave", [
            "project" => $project,
        ]);
    }

    public function postLeaveTeam(LeaveTeamRequest $request, $slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $this->authorize("leave-team", $project);

        TeamMembers::removeUserFromTeam($project);

        flash(__("tessify-core::projects.leave_team_success"))->success();
        return redirect()->route("projects.team.view", $project->slug);
    }

    public function getRemoveMember($slug, $userSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $user = Users::findBySlug($userSlug);
        if (!$user)
        {
            flash(__("tessify-core::profiles.user_not_found"))->error();
            return redirect()->route("projects.view", $project->slug);
        }
        
        return view("tessify-core::pages.projects.teams.remove-member", [
            "project" => $project,
        ]);
    }

    public function postRemoveMember(RemoveMemberFromTeamRequest $request, $slug, $userSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $this->authorize("manage-team-members", $project);

        $user = Users::findBySlug($userSlug);
        if (!$user)
        {
            flash(__("tessify-core::profiles.user_not_found"))->error();
            return redirect()->route("projects.view", $project->slug);
        }

        TeamMembers::removeUserFromTeam($project, $user);

        flash(__("tessify-core::projects.removed_from_team", ["name" => $user->formattedName]))->success();
        return redirect()->route("projects.teams.view", $project->slug);
    }

    public function getInvite($slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        return view("tessify-core::pages.projects.team.invite-people", [
            "project" => $project,
            "users" => Users::getAllNotInProjectTeam($project),
        ]);
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

    public function getChangeMemberRoles($slug, $userSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $user = Users::findBySlug($userSlug);
        if (!$user)
        {
            flash(__("tessify-core::profiles.user_not_found"))->error();
            return redirect()->route("projects.team.view", $project->slug);
        }

        $teamMember = Projects::findTeamMember($project, $user);
        if (!$teamMember)
        {
            flash(__("tessify-core::projects.team_member_not_found"))->error();
            return redirect()->route("projects.team.view", $project->slug);
        }

        return view("tessify-core::pages.projects.teams.members.change-roles", [
            "user" => $user,
            "project" => $project,
            "member" => $teamMember,
            "roles" => Projects::getOutstandingRoles($project),
            "oldInput" => collect([
                "team_role_id" => old("team_role_id"),
            ])
        ]);
    }

    public function postChangeMemberRoles(UpdateTeamMemberRolesRequest $request, $slug, $userSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $this->authorize("manage-team-members", $project);

        $user = Users::findBySlug($userSlug);
        if (!$user)
        {
            flash(__("tessify-core::profiles.user_not_found"))->error();
            return redirect()->route("projects.team.view", $project->slug);
        }

        $teamMember = Projects::findTeamMember($project, $user);
        if (!$teamMember)
        {
            flash(__("tessify-core::projects.team_member_not_found"))->error();
            return redirect()->route("projects.team.view", $project->slug);
        }

        TeamMembers::updateRolesFromRequest($teamMember, $request);

        flash(__("tessify-core::projects.change_roles_success"))->success();
        return redirect()->route("projects.team.view", $project->slug);
    }
}