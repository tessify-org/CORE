<?php

namespace Tessify\Core\Http\Controllers\Api;

use TeamRoles;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Api\Projects\TeamRoles\CreateTeamRoleRequest;
use Tessify\Core\Http\Requests\Api\Projects\TeamRoles\UpdateTeamRoleRequest;
use Tessify\Core\Http\Requests\Api\Projects\TeamRoles\DeleteTeamRoleRequest;
use Tessify\Core\Http\Requests\Api\Projects\TeamRoles\UnassignTeamRoleRequest;

class TeamRoleController extends Controller
{
    public function postCreate(CreateTeamRoleRequest $request)
    {
        $role = TeamRoles::createFromApiRequest($request);

        return response()->json([
            "status" => "success",
            "role" => $role,
        ]);
    }

    public function postUpdate(UpdateTeamRoleRequest $request)
    {
        $role = TeamRoles::updateFromApiRequest($request);

        return response()->json([
            "status" => "success",
            "role" => $role,
        ]);
    }

    public function postDelete(DeleteTeamRoleRequest $request)
    {
        TeamRoles::deleteFromApiRequest($request);

        return response()->json(["status" => "success"]);
    }
    
    public function postUnassign(UnassignTeamRoleRequest $request)
    {
        TeamRoles::unassignFromRequest($request);

        return response()->json(["status" => "success"]);
    }
}