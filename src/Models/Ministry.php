<?php

namespace Tessify\Core\Models;

use Tessify\Core\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Overtrue\LaravelSubscribe\Traits\Subscribable;

class Ministry extends Model
{
    use Sluggable;
    use Searchable;
    use Subscribable;

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

    public function tasks()
    {
        return $this->hasManyThrough(Task::class, Project::class);
    }
}