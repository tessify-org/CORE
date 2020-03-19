<?php

namespace Tessify\Core\Http\Controllers\Projects;

use Tasks;
use Projects;
use App\Http\Controllers\Controller;

class ProjectTaskController extends Controller
{
    public function getOverview($slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        return view("tessify-core::pages.projects.tasks.overview", [
            "project" => $project,
            "tasks" => Tasks::getAllForProject($project),
        ]);
    }
}