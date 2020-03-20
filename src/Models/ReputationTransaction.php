<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class ReputationTransaction extends Model
{
    protected $table = "reputation_transactions";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "user_id",
        "amount",
        "type",
        "name",
        "target_type",
        "target_id",
    ];

    //
    // Relationships
    //

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}