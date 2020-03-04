<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class TaskProgressReportAttachment extends Model
{
    protected $table = "task_progress_report_attachments";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "task_progress_report_id",
        "file_url",
        "description",
    ];

    //
    // Relationships
    //

    public function progressReport()
    {
        return $this->belongsTo(TaskProgressReport::class, "task_progress_report_id", "id");
    }
}