<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = "tags";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "name",
    ];

    //
    // Relationships
    //

    public function projects()
    {
        return $this->morhpedByMany(Project::class);
    }

    public function tasks()
    {
        return $this->morhpedByMany(Task::class);
    }
}