<?php

namespace Tessify\Core\Models;

use Uuid;
use Illuminate\Database\Eloquent\Model;

class TaskProgressReport extends Model
{
    protected $table = "task_progress_reports";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "uuid",
        "user_id",
        "task_id",
        "message",
        "hours",
        "completed",
    ];
    protected $casts = [
        "completed" => "boolean",
    ];

    //
    // Uuid
    //
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    //
    // Relationships
    //

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function attachments()
    {
        return $this->hasMany(TaskProgressReportAttachment::class);
    }

    public function reviews()
    {
        return $this->hasMany(TaskProgressReportReview::class);
    }
}