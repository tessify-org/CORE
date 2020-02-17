<?php

namespace Tessify\Core\Services\ModelServices;

use Tessify\Core\Models\Project;
use Tessify\Core\Models\ProjectCategory;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Projects\Categories\CreateProjectCategoryRequest;
use Tessify\Core\Http\Requests\Projects\Categories\UpdateProjectCategoryRequest;

class ProjectCategoryService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\ProjectCategory";
    }

    public function preload($instance)
    {
        return $instance;
    }
    
    public function findForProject(Project $project)
    {
        return $this->find($project->project_category_id);
    }

    public function createFromRequest(CreateProjectCategoryRequest $request)
    {
        return ProjectCategory::create([
            "name" => $request->name,
            "label" => $request->label,
        ]);
    }

    public function updateFromRequest(ProjectCategory $category, UpdateProjectCategoryRequest $request)
    {
        $category->name = $request->name;
        $category->label = $request->label;
        $category->save();

        return $category;
    }
}