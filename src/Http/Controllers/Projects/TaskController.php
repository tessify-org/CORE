<?php

namespace Tessify\Core\Http\Controllers\Projects;

use Tasks;
use Projects;
use TaskStatuses;
use TaskCategories;
use TaskSeniorities;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Projects\Tasks\CreateTaskRequest;
use Tessify\Core\Http\Requests\Projects\Tasks\UpdateTaskRequest;
use Tessify\Core\Http\Requests\Projects\Tasks\DeleteTaskRequest;

class TaskController extends Controller
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

    public function getView($slug, $taskSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }
        
        return view("tessify-core::pages.projects.tasks.view", [
            "project" => $project,
            "task" => $task,
        ]);
    }
    
    public function getCreate($slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        return view("tessify-core::pages.projects.tasks.create", [
            "project" => $project,
            "categories" => TaskCategories::getAll(),
            "seniorities" => TaskSeniorities::getAll(),
            "oldInput" => collect([
                "task_seniority_id" => old("task_seniority_id"),
                "task_category_id" => old("task_category_id"),
                "title" => old("title"),
                "description" => old("description"),
                "complexity" => old("complexity"),
                "estimated_hours" => old("estimated_hours"),
            ])
        ]);
    }

    public function postCreate(CreateTaskRequest $request, $slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::createFromRequest($project, $request);

        flash(__("tessify-core::projects.tasks_created"))->success();
        return redirect()->route("projects.tasks.view", ["slug" => $slug, "taskSlug" => $task->slug]);
    }

    public function getEdit($slug, $taskSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findPreloadedBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }

        return view("tessify-core::pages.projects.tasks.edit", [
            "project" => $project,
            "task" => $task,
            "statuses" => TaskStatuses::getAll(),
            "categories" => TaskCategories::getAll(),
            "seniorities" => TaskSeniorities::getAll(),
            "oldInput" => collect([
                "task_seniority_id" => old("task_seniority_id"),
                "task_category_id" => old("task_category_id"),
                "title" => old("title"),
                "description" => old("description"),
                "complexity" => old("complexity"),
                "estimated_hours" => old("estimated_hours"),
            ])
        ]);
    }

    public function postEdit(UpdateTaskRequest $request, $slug, $taskSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }

        Tasks::updateFromRequest($task, $request);

        flash(__("tessify-core::projects.tasks_updated"))->success();
        return redirect()->route("projects.tasks.view", ["slug" => $project->slug, "taskSlug" => $task->slug]);
    }

    public function getDelete($slug, $taskSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findPreloadedBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }

        return view("tessify-core::pages.projects.tasks.delete", [
            "project" => $project,
            "task" => $task,
        ]);
    }

    public function postDelete(DeleteTaskRequest $request, $slug, $taskSlug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $task = Tasks::findPreloadedBySlug($taskSlug);
        if (!$task)
        {
            flash(__("tessify-core::projects.task_not_found"))->error();
            return redirect()->route("projects.tasks", $project->slug);
        }

        $task->delete();

        flash(__("tessify-core::projects.tasks_deleted"))->error();
        return redirect()->route("projects.tasks", $project->slug);
    }
}