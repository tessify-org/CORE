<?php

namespace Tessify\Core\Models;

use Uuid;
use Illuminate\Database\Eloquent\Model;

class TeamMemberApplication extends Model
{
    protected $table = "team_member_applications";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "project_id",
        "user_id",
        "team_role_id",
        "uuid",
        "motivation",
        "processed",
        "accepted",
    ];
    protected $casts = [
        "processed" => "boolean",
        "accepted" => "boolean",
    ];

    //
    // UUID generation
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

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function teamRole()
    {
        return $this->belongsTo(TeamRole::class);
    }
}