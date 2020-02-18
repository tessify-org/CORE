<?php

namespace Tessify\Core\Services\ModelServices;

use Auth;
use Uploader;

use Tessify\Core\Models\Project;
use Tessify\Core\Models\ProjectResource;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Api\Projects\Resources\CreateProjectResourceRequest;
use Tessify\Core\Http\Requests\Api\Projects\Resources\UpdateProjectResourceRequest;

class ProjectResourceService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\ProjectResource";
    }
    
    public function preload($instance)
    {
        // Convert file url from relative to absolute
        $instance->file_url = asset($instance->file_url);
        
        return $instance;
    }

    public function getAllPreloadedForProject(Project $project)
    {
        $out = [];

        foreach ($this->getAllPreloaded() as $resource)
        {
            if ($resource->project_id == $project->id)
            {
                $out[] = $resource;
            }
        }

        return $out;
    }

    public function createFromRequest(CreateProjectResourceRequest $request)
    {
        $user = Auth::user();

        $resource = ProjectResource::create([
            "project_id" => $request->project_id,
            "user_id" => $user->id,
            "title" => $request->title,
            "description" => $request->description,
            "file_url" => Uploader::upload($request->file("file"), "files/job_resources"),
            "file_size" => $request->file("file")->getSize(),
        ]);

        return $resource;
    }
    
    public function updateFromRequest(UpdateProjectResourceRequest $request)
    {
        $resource = $this->find($request->job_resource_id);
        if ($resource)
        {
            $resource->title = $request->title;
            $resource->description = $request->description;
    
            if ($request->hasFile("file"))
            {
                $resource->file_url = Uploader::upload($request->file("file"), "files/job_resources");
                $resource->file_size = $request->file("file")->getSize();
            }
            
            $resource->save();

            return $resource;
        }

        return false;
    }
}