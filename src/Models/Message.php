<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = "messages";
    protected $guarded = ["id", "created_id", "updated_id"];
    protected $fillable = [
        "sender_id",
        "receiver_id",
        "reply_to_id",
        "subject",
        "message",
        "read",
    ];
    protected $casts = [
        "read" => "boolean",
    ];

    //
    // Relationships
    //

    public function sender()
    {
        return $this->belongsTo(\App\Models\User::class, "sender_id", "id");
    }

    public function receiver()
    {
        return $this->belongsTo(\App\Models\User::class, "receiver_id", "id");
    }

    public function replyTo()
    {
        return $this->belongsTo(\Tessify\Core\Models\Message::class, "reply_to_id", "id");
    }
}