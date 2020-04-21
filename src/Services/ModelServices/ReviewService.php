<?php

namespace Tessify\Core\Services\ModelServices;

use App\Models\User;
use Tessify\Core\Models\Review;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;

class ReviewService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\Review";
    }
    
    public function preload($instance)
    {
        $instance->view_href = route("reviews.view", $instance->uuid);
        $instance->formatted_date = $instance->created_at->format("d-m-Y H:m:s");
        
        switch ($instance->reviewable_type)
        {
            case "App\\Models\\User":
                $instance->formatted_type = __("tessify-core::reviews.type_user");
                $instance->formatted_name = $instance->reviewable->formatted_name;
            break;
            case "Tessify\\Core\\Models\\Task":
                $instance->formatted_type = __("tessify-core::reviews.type_task");
                $instance->formatted_name = $instance->reviewable->title;
            break;
            case "Tessify\\Core\\Models\\Project":
                $instance->formatted_type = __("tessify-core::reviews.type_project");
                $instance->formatted_name = $instance->reviewable->title;
            break;
        }

        return $instance;
    }

    public function findByUuid($uuid)
    {
        foreach ($this->getAll() as $review)
        {
            if ($review->uuid == $uuid)
            {
                return $review;
            }
        }

        return false;
    }

    public function findPreloadedByUuid($uuid)
    {
        foreach ($this->getAllPreloaded() as $review)
        {
            if ($review->uuid == $uuid)
            {
                return $review;
            }
        }

        return false;
    }

    public function getMyReviews(User $user = null)
    {
        if (is_null($user)) $user = auth()->user();

        $out = [];

        foreach ($this->getAllPreloaded() as $review)
        {
            if ($review->user_id == $user->id)
            {
                $out[] = $review;
            }
        }

        return collect($out);
    }

    public function createFromRequest(CreateReviewRequest $request, $reviewable)
    {
        return Review::create([
            "user_id" => auth()->user()->id,
            "reviewable_type" => get_class($reviewable),
            "reviewable_id" => $reviewable->id,
            "rating" => $request->rating,
            "message" => $request->message,
        ]);
    }

    public function updateFromRequest(UpdateReviewRequest $request, Review $review)
    {
        $review->rating = $review->rating;
        $review->message = $review->message;
        $review->save();
        
        return $review;
    }
}