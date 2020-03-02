<?php

namespace Tessify\Core\Models;

use Uuid;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = "messages";
    protected $guarded = ["id", "created_id", "updated_id"];
    protected $fillable = [
        "uuid",
        "sender_id",
        "receiver_id",
        "reply_to_id",
        "subject",
        "message",
        "read",
        "read_on",
    ];
    protected $casts = [
        "read" => "boolean",
    ];
    protected $dates = [
        "read_on",
    ];

    //
    // Uuid
    //

    public static function boot()
    {
        parent::boot();
        
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

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