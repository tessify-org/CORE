<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationLocation extends Model
{
    protected $table = "organization_locations";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "organization_id",
        "building_name",
        "address",
        "latitude",
        "longitude",
    ];

    //
    // Relationships
    //

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}