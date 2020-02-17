<?php

namespace Tessify\Core\Services\ModelServices;

use Tessify\Core\Models\Project;
use Tessify\Core\Models\WorkMethod;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Jobs\WorkMethods\CreateWorkMethodRequest;
use Tessify\Core\Http\Requests\Jobs\WorkMethods\UpdateWorkMethodRequest;

class WorkMethodService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;

    public function __construct()
    {
        $this->model = "Tessify\Core\Models\WorkMethod";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function findForProject(Project $project)
    {
        return $this->find($project->work_method_id);
    }

    public function createFromRequest(CreateWorkMethodRequest $request)
    {
        return WorkMethod::create([
            "name" => $request->name,
            "label" => $request->label,
            "description" => $request->description,
            "external_url" => $request->external_url,
        ]);
    }

    public function updateFromRequest(WorkMethod $workMethod, UpdateWorkMethodRequest $request)
    {
        $workMethod->name = $request->name;
        $workMethod->label = $request->label;
        $workMethod->description = $request->description;
        $workMethod->external_url = $request->external_url;
        $workMethod->save();

        return $workMethod;
    }
}