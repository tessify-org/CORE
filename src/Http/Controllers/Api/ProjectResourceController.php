<?php

namespace Tessify\Core\Http\Controllers\Api;

use Uploader;
use Projects;
use ProjectResources;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Api\Projects\Resources\UploadFilesRequest;
use Tessify\Core\Http\Requests\Api\Projects\Resources\CreateProjectResourceRequest;
use Tessify\Core\Http\Requests\Api\Projects\Resources\UpdateProjectResourceRequest;
use Tessify\Core\Http\Requests\Api\Projects\Resources\DeleteProjectResourceRequest;

class ProjectResourceController extends Controller
{
    public function postUploadFiles(UploadFilesRequest $request, $slug)
    {
        // Grab the project we want to complete
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        // Process all of the uploaded files and turn them into resources
        $resources = ProjectResources::processMultipleUploadsForProject($project, $request);

        // Return a JSON response
        return response()->json([
            "status" => "success",
            "resources" => $resources,
        ]);
    }   

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

    public function postUpdateResource(UpdateProjectResourceRequest $request)
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

    public function postDeleteResource(DeleteProjectResourceRequest $request)
    {   
        $resource = ProjectResources::find($request->project_resource_id);
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