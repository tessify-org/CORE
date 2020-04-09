<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectPhase extends Model
{
    protected $table = "project_phases";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "name",
    ];

    //
    // Relationships
    //

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    //
    // Accessors
    //

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    //
    // Mutators
    //

    public function setNameAttribute($value)
    {
        $this->attributes["name"] = strtolower($value);
    }
}