<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Tag extends Model
{
    use Sluggable;
    
    protected $table = "tags";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "slug",
        "name",
    ];

    //
    // Sluggable
    //

    public function sluggable()
    {
        return ["slug" => ["source" => "name"]];
    }
    
    //
    // Relationships
    //

    public function projects()
    {
        return $this->morphedByMany(Project::class, "taggable");
    }

    public function tasks()
    {
        return $this->morphedByMany(Task::class, "taggable");
    }
}