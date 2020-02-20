<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $table = "team_members";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "project_id",
        "user_id",
    ];

    //
    // Relationships
    //

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function teamRoles()
    {
        return $this->belongsToMany(TeamRole::class);
    }

    //
    // Accessors
    //

    public function getTitleAttribute()
    {
        $roles = $this->teamRoles;
        $numRoles = $roles->count();
        if ($numRoles > 0)
        {
            $out = "";

            if ($numRoles == 1)
            {
                $out = $roles->get(0)->name;
            }
            else if($numRoles == 2)
            {
                $out = $roles->get(0)->name." & ".$roles->get(1)->name;
            }
            else
            {
                $i = 0;
                foreach ($roles as $role)
                {
                    if ($i == 0)
                    {
                        $out = $role->name;
                    }
                    else if ($i == ($numRoles - 1))
                    {
                        $out = " & ".$role->name;
                    }
                    else
                    {
                        $out = ", ".$role->name;
                    }
                    $i++;
                }
            }

            return $out;
        }
        else
        {
            return "Onbekende rol";
        }
    }
}