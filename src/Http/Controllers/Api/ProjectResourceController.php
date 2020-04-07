<?php

namespace Tessify\Core\Http\Controllers\Api;

use ProjectResources;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Api\Projects\Resources\CreateProjectResourceRequest;
use Tessify\Core\Http\Requests\Api\Projects\Resources\UpdateProjectResourceRequest;
use Tessify\Core\Http\Requests\Api\Projects\Resources\DeleteProjectResourceRequest;

class ProjectResourceController extends Controller
{
    public function postCreateResource(CreateProjectResourceRequest $request)
    {
        $resource = ProjectResources::createFromRequest($request);
        if ($resource)
        {
            return response()->json([
                "status" => "success",
                "resource" => $resource,
            ]);
        }

        return response()->json([
            "status" => "error",
            "error" => "Resource kon niet worden geupload"
        ]);
    }

    public function postUpdateResource(UpdateJobResourceRequest $request)
    {
        $resource = ProjectResources::updateFromRequest($request);
        if ($resource)
        {
            return response()->json([
                "status" => "success",
                "resource" => $resource,
            ]);
        }

        return response()->json([
            "status" => "error",
            "error" => "Resource kon niet worden aangepast."
        ]);
    }

    public function postDeleteResource(DeleteJobResourceRequest $request)
    {   
        $resource = ProjectResources::find($request->job_resource_id);
        if ($resource)
        {
            $resource->delete();

            return response()->json(["status" => "success"]);
        }
        
        return response()->json([
            "status" => "error", 
            "error" => "Resource kon niet worden gevonden."
        ]);
    }
}