<?php

namespace Tessify\Core\Models;

use Uuid;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = "notifications";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "uuid",
        "user_id",
        "title",
        "description",
        "read",
        "read_on",
    ];
    protected $casts = [
        "read" => "boolean"
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

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}