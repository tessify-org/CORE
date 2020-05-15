<?php

namespace Tessify\Core\Services\ModelServices;

use DB;
use Skills;
use TeamMembers;

use Tessify\Core\Models\Project;
use Tessify\Core\Models\TeamRole;
use Tessify\Core\Models\TeamMember;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Projects\Teams\Roles\CreateTeamRoleRequest;
use Tessify\Core\Http\Requests\Projects\Teams\Roles\UpdateTeamRoleRequest;
use Tessify\Core\Http\Requests\Api\Projects\TeamRoles\CreateTeamRoleRequest as ApiCreateTeamRoleRequest;
use Tessify\Core\Http\Requests\Api\Projects\TeamRoles\UpdateTeamRoleRequest as ApiUpdateTeamRoleRequest;
use Tessify\Core\Http\Requests\Api\Projects\TeamRoles\DeleteTeamRoleRequest as ApiDeleteTeamRoleRequest;
use Tessify\Core\Http\Requests\Api\Projects\TeamRoles\UnassignTeamRoleRequest as ApiUnassignTeamRoleRequest;

class TeamRoleService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    private $teamMemberPivots;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\TeamRole";
    }

    public function preload($instance)
    {
        // Load role's required skills
        $instance->skills = Skills::getAllForTeamRole($instance);
        
        return $instance;
    }

    public function getAllForProject(Project $project)
    {
        $out = [];

        foreach ($this->getAllPreloaded() as $role)
        {
            if ($role->project_id == $project->id)
            {
                $out[] = $role;
            }
        }

        return $out;
    }

    public function getTeamMemberPivots()
    {
        if (is_null($this->teamMemberPivots))
        {
            $this->teamMemberPivots = DB::table("team_member_team_role")->get();
        }

        return $this->teamMemberPivots;
    }

    public function getTeamMemberForTeamRole(TeamRole $role)
    {
        $teamMember = null;

        foreach ($this->getTeamMemberPivots() as $pivot)
        {
            if ($pivot->team_role_id == $role->id)
            {
                $teamMember = TeamMembers::findPreloaded($pivot->team_member_id);
            }
        }

        return $teamMember;
    }

    public function findBySlug($slug)
    {
        foreach ($this->getAll() as $role)
        {
            if ($role->slug == $slug)
            {
                return $role;
            }
        }
        
        return false;
    }

    public function findPreloadedBySlug($slug)
    {
        foreach ($this->getAllPreloaded() as $role)
        {
            if ($role->slug == $slug)
            {
                return $role;
            }
        }

        return false;
    }

    public function findAllForMember(TeamMember $teamMember)
    {
        $out = [];

        foreach ($this->getTeamMemberPivots() as $pivot)
        {
            if ($pivot->team_member_id == $teamMember->id)
            {
                $out[] = $this->findPreloaded($pivot->team_role_id);
            }
        }

        return collect($out);
    }

    public function unassignFromRequest(ApiUnassignTeamRoleRequest $request)
    {
        $role = $this->find($request->team_role_id);
        $role->teamMembers()->detach();
    }

    public function createFromRequest(Project $project, CreateTeamRoleRequest $request)
    {
        return TeamRole::create([
            "project_id" => $project->id,
            "name" => $request->name,
            "description" => $request->description,
            "positions" => $request->positions,
        ]);
    }

    public function updateFromRequest(TeamRole $role, UpdateTeamRoleRequest $request)
    {
        $role->name = $request->name;
        $role->description = $request->description;
        $role->positions = $request->positions;
        $role->save();
    }

    public function deleteRole(TeamRole $role)
    {
        $role->teamMembers()->detach();
        $role->delete();
    }

    public function createFromApiRequest(ApiCreateTeamRoleRequest $request)
    {
        $role = TeamRole::create([
            "project_id" => $request->project_id,
            "name" => $request->name,
            "description" => $request->description,
            "positions" => $request->positions,
        ]);
        
        return $role;
    }

    public function updateFromApiRequest(ApiUpdateTeamRoleRequest $request)
    {
        $role = $this->find($request->team_role_id);
        $role->name = $request->name;
        $role->description = $request->description;
        $role->positions = $request->positions;
        $role->save();

        return $role;
    }

    public function deleteFromApiRequest(ApiDeleteTeamRoleRequest $request)
    {
        $role = $this->find($request->team_role_id);
        $role->delete();
    }
}