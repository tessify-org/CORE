<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentType extends Model
{
    protected $table = "assignment_types";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "name",
        "label",
    ];

    //
    // Relationships
    //

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}