<?php

namespace Tessify\Core\Services\ModelServices;

use DB;
use Auth;
use App\Models\User;
use Tessify\Core\Models\Task;
use Tessify\Core\Models\Skill;
use Tessify\Core\Models\TeamRole;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;

class SkillService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;

    private $skillUser;
    private $skillTask;
    private $skillTeamRole;

    public function __construct()
    {
        $this->model = "Tessify\Core\Models\Skill";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function getSkillUserPivots()
    {
        if (is_null($this->skillUser))
        {
            $this->skillUser = DB::table("skill_user")->get();
        }

        return $this->skillUser;
    }

    public function getSkillTaskPivots()
    {
        if (is_null($this->skillTask))
        {
            $this->skillTask = DB::table("skill_task")->get();
        }

        return $this->skillTask;
    }

    public function getSkillTeamRolePivots()
    {
        if (is_null($this->skillTeamRole))
        {
            $this->skillTeamRole = DB::table("skill_team_role")->get();
        }

        return $this->skillTeamRole;
    }

    public function getAllForTeamRole(TeamRole $role)
    {
        $out = [];

        foreach ($this->getSkillTeamRolePivots() as $pivot)
        {
            if ($pivot->team_role_id == $role->id)
            {
                $skill = $this->find($pivot->skill_id);
                if ($skill)
                {
                    $roleSkill = clone $skill;
                    $roleSkill->pivot = $pivot;

                    $out[] = $roleSkill;
                }
            }
        }

        return $out;
    }

    public function getAllForUser(User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        $out = [];

        foreach ($this->getSkillUserPivots() as $pivot)
        {
            if ($pivot->user_id == $user->id)
            {
                $skill = $this->find($pivot->skill_id);
                if ($skill)
                {
                    $userSkill = clone $skill;
                    $userSkill->pivot = $pivot;
                    
                    $out[] = $userSkill;
                }
            }
        }

        return $out;
    }
    
    public function getAllForTask(Task $task)
    {
        $out = [];

        foreach ($this->getSkillTaskPivots() as $pivot)
        {
            if ($pivot->task_id == $task->id)
            {
                $skill = $this->find($pivot->skill_id);
                if ($skill)
                {
                    $taskSkill = clone $skill;
                    $taskSkill->pivot = $pivot;
                    
                    $out[] = $taskSkill;
                }
            }
        }

        return $out;
    }

    public function findByName($name)
    {
        foreach ($this->getAll() as $skill)
        {
            if ($skill->name == $name)
            {
                return $skill;
            }
        }

        return false;
    }

    public function findOrCreateByName($name)
    {
        // Attempt to find the skill by it's name; if found return it
        $skill = $this->findByName($name);
        if ($skill) return $skill;

        // If we've reached this point we couldn't find the skill, so let's create one
        return $this->create(["name" => $name]);
    }

    public function create($data)
    {
        return Skill::create($data);
    }
}