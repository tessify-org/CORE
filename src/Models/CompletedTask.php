<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class CompletedTask extends Model
{
    protected $table = "completed_tasks";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "user_id",
        "task_id",
    ];

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
}