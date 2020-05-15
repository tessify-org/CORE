<?php

namespace Tessify\Core\Http\Controllers\Api;

use Messages;
use Exception;
use TeamMembers;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Api\Projects\TeamMembers\KickTeamMemberRequest;
use Tessify\Core\Http\Requests\Api\Projects\TeamMembers\UpdateTeamMemberRequest;

class TeamMemberController extends Controller
{
    public function postUpdate(UpdateTeamMemberRequest $request)
    {
        // Grab the team member
        $teamMember = TeamMembers::find($request->team_member_id);
        
        // Authorize the current user
        $this->authorize("manage-team-members", $teamMember->project);

        // Attempt to update and return appropriate response
        try
        {
            $newRoles = TeamMembers::updateRolesFromApiRequest($request);
    
            return response()->json([
                "status" => "success",
                "new_roles" => $newRoles,
            ]);
        }
        catch (Exception $e)
        {
            return response()->json([
                "status" => "error",
                "error" => $e->getMessage(),
            ]);
        }
    }

    public function postKick(KickTeamMemberRequest $request)
    {
        // Grab the team member
        $teamMember = TeamMembers::find($request->team_member_id);
        
        // Authorize the current user
        $this->authorize("manage-team-members", $teamMember->project);

        // Send message to the user informing they have been kicked from the team
        Messages::sendKickedFromProjectTeamMessage($teamMember->user, $teamMember->project, $request->reason);

        // Remove the team member from the team
        TeamMembers::kickFromApiRequest($request);

        // Return JSON response
        return response()->json(["status" => "success"]);
    }
}