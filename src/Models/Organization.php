<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Organization extends Model
{
    use Sluggable;

    protected $table = "organizations";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "organization_type_id",
        "ministry_id",
        "slug",
        "name",
        "abbreviation",
        "description",
        "website_url",
        "logo_url",
    ];

    //
    // Slug configuration
    //

    public function sluggable()
    {
        return ["slug" => ["source" => "name"]];
    }

    //
    // Relationships
    //

    public function type()
    {
        return $this->belongsTo(OrganizationType::class, "organization_type_id", "id");
    }

    public function ministry()
    {
        return $this->belongsTo(Ministry::class);
    }

    public function locations()
    {
        return $this->hasMany(OrganizationLocation::class);
    }

    public function departments()
    {
        return $this->hasMany(OrganizationDepartment::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assigment::class);
    }
}