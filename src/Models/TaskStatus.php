<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    protected $table = "tasks";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "name",
        "label",
    ];

    //
    // Relationships
    //

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}