<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectResource extends Model
{
    protected $table = "project_resources";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "project_id",
        "user_id",
        "title",
        "description",
        "file_url",
        "file_size",
    ];

    //
    // Relationships
    //

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}