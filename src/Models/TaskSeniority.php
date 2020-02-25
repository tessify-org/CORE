<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class TaskSeniority extends Model
{
    protected $table = "task_seniorities";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "name",
        "label",
    ];

    //
    // Relationships
    //

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}