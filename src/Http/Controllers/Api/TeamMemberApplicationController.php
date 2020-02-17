<?php

namespace Tessify\Core\Http\Controllers\Api;

use TeamMemberApplications;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Api\Projects\TeamMemberApplications\DenyTeamMemberApplicationRequest;
use Tessify\Core\Http\Requests\Api\Projects\TeamMemberApplications\AcceptTeamMemberApplicationRequest;
use Tessify\Core\Http\Requests\Api\Projects\TeamMemberApplications\CreateTeamMemberApplicationRequest;
use Tessify\Core\Http\Requests\Api\Projects\TeamMemberApplications\UpdateTeamMemberApplicationRequest;
use Tessify\Core\Http\Requests\Api\Projects\TeamMemberApplications\DeleteTeamMemberApplicationRequest;

class TeamMemberApplicationController extends Controller
{
    public function postCreateApplication(CreateTeamMemberApplicationRequest $request)
    {
        $application = TeamMemberApplications::createFromRequest($request);

        return response()->json([
            "status" => "success",
            "application" => $application    
        ]);
    }

    public function postUpdateApplication(UpdateTeamMemberApplicationRequest $request)
    {
        $application = TeamMemberApplications::updateFromRequest($request);

        return response()->json([
            "status" => "success",
            "application" => $application    
        ]);
    }

    public function postDeleteApplication(DeleteTeamMemberApplicationRequest $request)
    {

        return response()->json(["status" => "success"]);
    }

    public function postAcceptApplication(AcceptTeamMemberApplicationRequest $request)
    {
        TeamMemberApplications::accept($request);

        return response()->json(["status" => "success"]);
    }

    public function postDenyApplication(DenyTeamMemberApplicationRequest $request)
    {
        TeamMemberApplications::deny($request);

        return response()->json(["status" => "success"]);
    }
}