<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comments";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "user_id",
        "commentable_id",
        "commentable_type",
        "body",
    ];

    //
    // Relationships
    //

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}