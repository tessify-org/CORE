<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class TaskCategory extends Model
{
    protected $table = "task_categories";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "name",
        "description",
    ];

    //
    // Relationships
    //

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}