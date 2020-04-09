<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Ministry extends Model
{
    use Sluggable;

    protected $table = "ministries";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
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

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}