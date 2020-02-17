<?php

namespace Tessify\Core\Http\Controllers\Api;

use TeamRoles;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Api\Projects\TeamRoles\UnassignTeamRoleRequest;

class TeamRoleController extends Controller
{
    public function postUnassign(UnassignTeamRoleRequest $request)
    {
        TeamRoles::unassignFromRequest($request);

        return response()->json(["status" => "success"]);
    }
}