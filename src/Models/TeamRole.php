<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class TeamRole extends Model
{
    protected $table = "team_roles";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "project_id",
        "name",
        "description",
    ];

    //
    // Relationships
    //

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function teamMembers()
    {
        return $this->belongsToMany(TeamMember::class);
    }

    public function teamMemberApplications()
    {
        return $this->hasMany(TeamMemberApplication::class);
    }
}