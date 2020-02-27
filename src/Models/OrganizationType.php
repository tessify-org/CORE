<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationType extends Model
{
    protected $table = "organization_types";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "name",
        "label",
        "description",
    ];

    //
    // Relationships
    //

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }
}