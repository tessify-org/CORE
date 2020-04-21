<?php

namespace Tessify\Core\Models;

use Uuid;
use Illuminate\Database\Eloquent\Model;

class ReviewRequest extends Model
{
    protected $table = "review_requests";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "uuid",
        "user_id",
        "reviewrequestable_type",
        "reviewrequestable_id",
        "reason",
        "status",
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

    public function targetUser()
    {
        return $this->belongsTo(\App\Models\User::class, "target_user_id", "id");
    }

    public function reviewrequestable()
    {
        return $this->morphTo();
    }
}