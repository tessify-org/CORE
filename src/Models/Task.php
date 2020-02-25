<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Task extends Model
{
    use Sluggable;

    protected $table = "tasks";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "project_id",
        "task_status_id",
        "task_category_id",
        "task_seniority_id",
        "title",
        "description",
        "complexity",
        "estimated_hours",
        "realized_hours",
    ];

    //
    // Slug configuration
    //

    public function sluggable()
    {
        return ["slug" => ["source" => "title"]];
    }

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

    public function category()
    {
        return $this->belongsTo(TaskCategory::class);
    }

    public function seniority()
    {
        return $this->belongsTo(TaskSeniority::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class);
    }

    public function dependsOn()
    {
        return $this->belongsToMany(Task::class, "task_dependencies", "master_task_id", "slave_task_id");
    }

    public function childTasks()
    {
        return $this->belongsToMany(Task::class, "task_dependencies", "slave_task_id", "master_task_id");
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, "commentable");
    }
}