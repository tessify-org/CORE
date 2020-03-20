<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class BugReport extends Model
{
    protected $table = "bug_reports";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "user_id",
        "url",
        "severity",
        "report",
    ];

    //
    // Relationships
    // 

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}