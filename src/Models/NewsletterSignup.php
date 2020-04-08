<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSignup extends Model
{
    protected $table = "newsletter_signups";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "user_id",
        "email",
    ];

    //
    // Relationships
    //

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}