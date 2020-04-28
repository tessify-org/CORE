<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class WhitelistedDomain extends Model
{
    protected $table = "whitelisted_domains";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = ["domain"];
}