<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = "skills";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "name",
    ];

    //
    // Relationships
    // 

    public function users()
    {
        return $this->belongsToMany(App\Models\User::class);
    }

    public function teamRoles()
    {
        return $this->belongsToMany(TeamRole::class);
    }
}