<?php

namespace Tessify\Core\Services\ModelServices;

use Users;
use Tasks;
use Projects;
use ReviewRequests;
use App\Models\User;
use Tessify\Core\Models\Task;
use Tessify\Core\Models\Review;
use Tessify\Core\Models\Project;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Reviews\CreateReviewRequest;
use Tessify\Core\Http\Requests\Reviews\UpdateReviewRequest;

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

    public function findTarget($type, $slug)
    {
        switch ($type)
        {
            case "user":
                return Users::findBySlug($slug);
            break;
            case "task":
                return Tasks::findBySlug($slug);
            break;
            case "project":
                return Projects::findBySlug($slug);
            break;
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

    public function createFromRequest(CreateReviewRequest $request, $type, $slug)
    {
        // Grab the target we're reviewing
        $target = $this->findTarget($type, $slug);
        if (!$target)
        {
            flash(__("tessify-core::reviews.target_not_found"))->error();
            return redirect()->route("reviews");
        }

        // Complete any outstanding review request that matches the target
        ReviewRequests::completeOutstandingRequestFor($type, $slug);

        // Create and return the review
        return Review::create([
            "user_id" => auth()->user()->id,
            "reviewable_type" => get_class($target),
            "reviewable_id" => $target->id,
            "rating" => $request->rating,
            "message" => $request->message,
            "public" => $request->public === "true" ? true : false,
        ]);
    }

    public function updateFromRequest(UpdateReviewRequest $request, Review $review)
    {
        // Update the review
        $review->rating = $review->rating;
        $review->message = $review->message;
        $review->public = $request->public === "true" ? true : false;
        $review->save();

        // Return the review
        return $review;
    }
}