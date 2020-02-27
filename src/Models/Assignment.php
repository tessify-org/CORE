<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $table = "assignments";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "user_id",
        "assignment_type_id",
        "organization_id",
        "organization_department_id",
        "title",
        "order",
        "current",
        "start_date",
        "end_date",
    ];
    protected $casts = [
        "current" => "boolean"
    ];
    protected $dates = [
        "start_date",
        "end_date",
    ];

    //
    // Relationships
    //

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignmentType()
    {
        return $this->belongsTo(AssignmentType::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function department()
    {
        return $this->belongsTo(OrganizationDepartment::class, "organization_department_id", "id");
    }
}