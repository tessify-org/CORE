<?php

namespace Tessify\Core\Services\ModelServices;

use Projects;
use TaskStatuses;
use TaskCategories;
use TaskSeniorities;
use Tessify\Core\Models\Task;
use Tessify\Core\Models\Project;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Projects\Tasks\CreateTaskRequest;
use Tessify\Core\Http\Requests\Projects\Tasks\UpdateTaskRequest;

class TaskService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\Task";
    }
    
    public function preload($instance)
    {
        // Preload relationships
        $instance->status = TaskStatuses::findForTask($instance);
        $instance->category = TaskCategories::findForTask($instance);
        $instance->seniority = TaskSeniorities::findForTask($instance);

        // Add HREF to the view task page for this task
        $project = Projects::find($instance->project_id);
        $instance->view_href = route("projects.tasks.view", ["slug" => $project->slug, "taskSlug" => $instance->slug]);

        return $instance;
    }

    public function getAllForProject(Project $project)
    {
        $out = [];

        foreach ($this->getAllPreloaded() as $task)
        {
            if ($task->project_id == $project->id)
            {
                $out[] = $task;
            }
        }

        return $out;
    }

    public function findBySlug($slug)
    {
        foreach ($this->getAll() as $task)
        {
            if ($task->slug == $slug)
            {
                return $task;
            }
        }

        return false;
    }

    public function findPreloadedBySlug($slug)
    {
        foreach ($this->getAllPreloaded() as $task)
        {
            if ($task->slug == $slug)
            {
                return $task;
            }
        }

        return false;
    }

    public function createFromRequest(Project $project, CreateTaskRequest $request)
    {
        $open = TaskStatuses::findByName("open");

        return Task::create([
            "project_id" => $project->id,
            "task_status_id" => $open->id,
            "task_category_id" => $request->task_category_id,
            "task_seniority_id" => $request->task_seniority_id,
            "title" => $request->title,
            "description" => $request->description,
            "complexity" => $request->complexity,
            "estimated_hours" => $request->estimated_hours,
        ]);
    }

    public function updateFromRequest(Task $task, UpdateTaskRequest $request)
    {
        $task->task_status_id = $request->task_status_id;
        $task->task_category_id = $request->task_category_id;
        $task->task_seniority_id = $request->task_seniority_id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->complexity = $request->complexity;
        $task->estimated_hours = $request->estimated_hours;
        $task->realized_hours = $request->realized_hours;
        $task->save();
    }
}