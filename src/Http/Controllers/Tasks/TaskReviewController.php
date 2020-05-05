<?php

namespace Tessify\Core\Http\Controllers\Tasks;

use Tasks;
use Reviews;

use App\Http\Controllers\Controller;

class TaskReviewController extends Controller
{
    public function getOverview($slug)
    {
        // Grab the task we want to view
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        // Render the task review overview page
        return view("tessify-core::pages.tasks.reviews.overview", [
            "task" => $task,
            "reviews" => Reviews::getAllForTask($task),
            "strings" => collect([
                "no_records" => __("tessify-core::tasks.reviews_no_records"),
            ]),
        ]);
    }

    public function getView($slug, $uuid)
    {
        // Grab the task we want to view
        $task = Tasks::findPreloadedBySlug($slug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("tasks");
        }

        // Grab the task review we want to view
        $review = Reviews::findByUuid($uuid);
        if (!$review)
        {
            flash(__("tessify-core::tasks.review_not_found"))->error();
            return redirect()->route("tasks.view", $task->slug);
        }
        
        // Render the task review page
        return view("tessify-core::pages.tasks.reviews.view", [
            "task" => $task,
            "review" => $review,
        ]);
    }
}