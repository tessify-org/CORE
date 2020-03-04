<?php

namespace Tessify\Core\Models;

use Uuid;
use Illuminate\Database\Eloquent\Model;

class TaskProgressReportReview extends Model
{
    protected $table = "task_progress_report_reviews";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "uuid",
        "task_progress_report_id",
        "user_id",
        "message",
        "read_by_assigned_user",
    ];
    protected $casts = [
        "read_by_assigned_user" => "boolean",
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
    
    public function report()
    {
        return $this->belongsTo(TaskProgressReport::class, "task_progress_report_id", "id");
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}