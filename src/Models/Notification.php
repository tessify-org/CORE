<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = "notifications";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "user_id",
        "type",
        "title",
        "description",
        "read",
    ];
    protected $casts = [
        "read" => "boolean"
    ];

    //
    // Relationships
    // 

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}