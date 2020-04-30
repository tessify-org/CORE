<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationDepartment extends Model
{
    protected $table = "organization_departments";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "organization_id",
        "name",
    ];

    //
    // Relationships
    //

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}