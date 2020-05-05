<?php

namespace Tessify\Core\Http\Controllers\Projects;

use Reviews;
use Projects;

use App\Http\Controllers\Controller;

class ProjectReviewController extends Controller
{
    public function getOverview($slug)
    {
        // Grab the project we want to complete
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        // Render the project review overview page
        return view("tessify-core::pages.projects.reviews.overview", [
            "project" => $project,
            "reviews" => Reviews::getAllForProject($project),
            "strings" => collect([
                "no_records" => __("tessify-core::projects.reviews_no_records"),
            ]),
        ]);
    }
}