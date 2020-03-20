<?php

namespace Tessify\Core\Http\Controllers\Projects;

use Auth;
use Users;
use Skills;
use Comments;
use Projects;
use Reputation;
use WorkMethods;
use ProjectStatuses;
use ProjectResources;
use ProjectCategories;

use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Projects\CreateProjectRequest;
use Tessify\Core\Http\Requests\Projects\UpdateProjectRequest;
use Tessify\Core\Http\Requests\Projects\DeleteProjectRequest;

class ProjectController extends Controller
{
    public function getOverview()
    {
        return view("tessify-core::pages.projects.overview", [
            "projects" => Projects::getAllPreloaded(),
            "statuses" => ProjectStatuses::getAll(),
            "categories" => ProjectCategories::getAll(),
        ]);
    }

    public function getView($slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        return view("tessify-core::pages.projects.view", [
            "project" => $project,
            "user" => Users::current(),
            "author" => Projects::getAuthor($project),
            "resources" => Projects::getResources($project),
            "comments" => Comments::getAllPreloadedForProject($project),
        ]);
    }

    public function getCreate()
    {
        return view("tessify-core::pages.projects.create", [
            "statuses" => Projectstatuses::getAll(),
            "categories" => ProjectCategories::getAll(),
            "workMethods" => WorkMethods::getAll(),
            "skills" => Skills::getAll(),
            "oldInput" => collect([
                "project_status_id" => old("project_status_id"),
                "project_category_id" => old("project_category_id"),
                "work_method_id" => old("work_method_id"),
                "title" => old("title"),
                "slogan" => old("slogan"),
                "problem" => old("problem"),
                "description" => old("description"),
                "starts_at" => old("starts_at"),
                "ends_at" => old("ends_at"),
                "resources" => old("resources"),
                "team_roles" => old("team_roles"),
            ])
        ]);
    }

    public function postCreate(CreateProjectRequest $request)
    {
        $project = Projects::createFromRequest($request);

        Reputation::givePoints(1000, "created_project", $project);

        flash(__("tessify-core::projects.project_created"))->success();
        return redirect()->route("projects.view", $project->slug);
    }

    public function getEdit($slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {   
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        return view("tessify-core::pages.projects.edit", [
            "project" => $project,
            "statuses" => Projectstatuses::getAll(),
            "categories" => ProjectCategories::getAll(),
            "workMethods" => WorkMethods::getAll(),
            "skills" => Skills::getAll(),
            "oldInput" => collect([
                "project_status_id" => old("project_status_id"),
                "project_category_id" => old("project_category_id"),
                "work_method_id" => old("work_method_id"),
                "title" => old("title"),
                "slogan" => old("slogan"),
                "problem" => old("problem"),
                "description" => old("description"),
                "starts_at" => old("starts_at"),
                "ends_at" => old("ends_at"),
                "resources" => old("resources"),
                "team_roles" => old("team_roles"),
            ])
        ]);
    }

    public function postEdit(UpdateProjectRequest $request, $slug)
    {
        $project = Projects::findBySlug($slug);
        if (!$project)
        {   
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $project = Projects::updateFromRequest($project, $request);

        flash(__("tessify-core::general.saved_changes"))->success();
        return redirect()->route("projects.view", $project->slug);
    }

    public function getDelete($slug)
    {
        $project = Projects::findBySlug($slug);
        if (!$project)
        {   
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        return view("tessify-core::pages.projects.delete", [
            "project" => $project,
        ]);
    }

    public function postDelete(DeleteProjectRequest $request, $slug)
    {
        $project = Projects::findBySlug($slug);
        if (!$project)
        {   
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $project->delete();

        flash(__("tessify-core::projects.project_deleted"))->success();
        return redirect()->route("projects");
    }

    public function getSubscribe($slug)
    {
        $project = Projects::findBySlug($slug);
        if (!$project)
        {   
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        Auth::user()->subscribe($project);

        flash(__("tessify-core::projects.view_subscribed"))->success();
        return redirect()->route("projects.view", $slug);
    }

    public function getUnsubscribe($slug)
    {
        $project = Projects::findBySlug($slug);
        if (!$project)
        {   
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        Auth::user()->unsubscribe($project);

        flash(__("tessify-core::projects.view_subscribed"))->success();
        return redirect()->route("projects.view", $slug);
    }
}