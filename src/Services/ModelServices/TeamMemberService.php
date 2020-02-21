<?php

namespace Tessify\Core\Services\ModelServices;

use Auth;
use Users;
use TeamRoles;
use App\Models\User;
use Tessify\Core\Models\Project;
use Tessify\Core\Models\TeamRole;
use Tessify\Core\Models\TeamMember;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Projects\Teams\UpdateTeamMemberRolesRequest;

class TeamMemberService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\TeamMember";
    }

    public function preload($instance)
    {
        $instance->user = Users::findPreloaded($instance->user_id);
        $instance->team_roles = TeamRoles::findAllForMember($instance);

        return $instance;
    }

    public function addUserToTeam(TeamRole $teamRole, User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        // Create the team member
        $teamMember = TeamMember::create([
            "project_id" => $teamRole->project_id,
            "user_id" => $user->id,
        ]);

        // Associate the team member with the role
        $teamMember->teamRoles()->attach($teamRole->id);

        // Return the team member
        return $teamMember;
    }

    public function removeUserFromTeam(Project $project, User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        foreach ($project->teamMembers as $teamMember)
        {
            if ($teamMember->user_id == $user->id)
            {
                $teamMember->teamRoles()->detach();
                $teamMember->delete();
            }
        }
    }

    public function updateRolesFromRequest(TeamMember $teamMember, UpdateTeamMemberRolesRequest $request)
    {
        $teamMember->teamRoles()->detach();
        $teamMember->teamRoles()->attach([$request->team_role_id]);
    }
}