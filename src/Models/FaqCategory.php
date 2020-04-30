<?php

namespace Tessify\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class FaqCategory extends Model
{
    use Sluggable;
    
    protected $table = "faq_categories";
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $fillable = [
        "name",
        "slug",
        "description",
    ];

    //
    // Slug configuration
    //

    public function sluggable()
    {
        return ["slug" => ["source" => "name"]];
    }

    //
    // Relationships
    //

    public function faqs()
    {
        return $this->hasMany(Faq::class, "faq_category_id", "id");
    }
}