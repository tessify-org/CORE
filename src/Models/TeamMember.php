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
        "title",
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
        return $this->belongsTo(App\Models\User::class);
    }

    public function teamRoles()
    {
        return $this->belongsToMany(TeamRole::class);
    }
}