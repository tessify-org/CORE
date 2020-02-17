<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = "tasks";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "project_id",
        "task_status_id",
        "title",
        "description",
    ];

    //
    // Relationships
    //

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
    public function status()
    {
        return $this->belongsTo(TaskStatus::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, "commentable");
    }
}