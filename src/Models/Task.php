<?php

namespace Tessify\Core\Models;

use Tessify\Core\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Overtrue\LaravelSubscribe\Traits\Subscribable;

class Task extends Model
{
    use Sluggable; 
    use Searchable;
    use Subscribable;

    protected $table = "tasks";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "author_id",
        "project_id",
        "task_status_id",
        "task_category_id",
        "task_seniority_id",
        "title",
        "description",
        "complexity",
        "estimated_hours",
        "realized_hours",
        "num_positions",
        "urgency",
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

    public function author()
    {
        return $this->belongsTo(\App\Models\User::class, "author_id", "id");
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
    public function status()
    {
        return $this->belongsTo(TaskStatus::class, "task_status_id", "id");
    }

    public function category()
    {
        return $this->belongsTo(TaskCategory::class, "task_category_id", "id");
    }

    public function seniority()
    {
        return $this->belongsTo(TaskSeniority::class, "task_seniority_id", "id");
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class)
                    ->withPivot('required_mastery', 'description')
                    ->withTimestamps();
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

    public function progressReports()
    {
        return $this->hasMany(TaskProgressReport::class);
    }

    public function completedTasks()
    {
        return $this->hasMany(\Tessify\Core\Models\CompletedTask::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, "taggable");
    }

    public function reviewRequests()
    {
        return $this->morphMany(ReviewRequest::class, "reviewrequestable");
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, "reviewable");
    }
}