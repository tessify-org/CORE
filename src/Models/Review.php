<?php

namespace Tessify\Core\Models;

use Uuid;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = "reviews";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "uuid",
        "user_id",
        "review_request_id",
        "reviewable_type",
        "reviewable_id",
        "rating",
        "message",
        "public",
    ];
    protected $casts = [
        "public" => "boolean",
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

    public function reviewRequest()
    {
        return $this->belongsTo(ReviewRequest::class);
    }

    public function reviewable()
    {
        return $this->morphTo();
    }
}