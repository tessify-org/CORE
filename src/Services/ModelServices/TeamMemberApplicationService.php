<?php

namespace Tessify\Core\Services\ModelServices;

use Auth;
use Users;
use TeamRoles;

use Tessify\Core\Models\Project;
use Tessify\Core\Models\TeamMemberApplication;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Api\Jobs\TeamMemberApplications\CreateTeamMemberApplicationRequest;
use Tessify\Core\Http\Requests\Api\Jobs\TeamMemberApplications\UpdateTeamMemberApplicationRequest;
use Tessify\Core\Http\Requests\Api\Jobs\TeamMemberApplications\AcceptTeamMemberApplicationRequest;
use Tessify\Core\Http\Requests\Api\Jobs\TeamMemberApplications\DenyTeamMemberApplicationRequest;

class TeamMemberApplicationService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\Task";
    }

    public function preload($instance)
    {
        $instance->user = Users::findPreloaded($instance->user_id);
        $instance->team_role = TeamRoles::find($instance->team_role_id);
        $instance->formatted_created_at = $instance->created_at->format("d-m-Y H:m:s");

        return $instance;
    }

    public function getAllForProject(Project $project)
    {
        $out = [];

        foreach ($this->getAllPreloaded() as $application)
        {
            if ($application->project_id == $project->id)
            {
                $out[] = $application;
            }
        }

        return $out;
    }

    public function deny(DenyTeamMemberApplicationRequest $request)
    {
        $application = $this->find($request->team_member_application_id);
        $application->processed = true;
        $application->accepted = false;
        $application->save();

        return $application;
    }

    public function accept(AcceptTeamMemberApplicationRequest $request)
    {
        $application = $this->find($request->team_member_application_id);
        $application->processed = true;
        $application->accepted = true;
        $application->save();

        return $application;
    }

    public function createFromRequest(CreateTeamMemberApplicationRequest $request)
    {
        $application = TeamMemberApplication::create([
            "project_id" => $request->project_id,
            "user_id" => Auth::user()->id,
            "team_role_id" => $request->team_role_id,
            "motivation" => $request->motivation,
        ]);

        return $this->preload($application);
    }

    public function updateFromRequest(UpdateTeamMemberApplicationRequest $request)
    {
        $application = $this->find($request->team_member_application_id);
        $application->motivation = $request->motivation;
        $application->save();

        return $this->preload($application);
    }
}