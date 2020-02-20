<?php

namespace Tessify\Core\Services\ModelServices;

use Auth;
use Dates;
use Users;
use Skills;
use Uploader;
use TeamRoles;
use WorkMethods;
use ProjectStatuses;
use ProjectResources;
use ProjectCategories;
use TeamMemberApplications;

use App\Models\User;
use Tessify\Core\Models\Project;
use Tessify\Core\Models\TeamRole;
use Tessify\Core\Models\TeamMemberApplication;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Http\Requests\Projects\CreateProjectRequest;
use Tessify\Core\Http\Requests\Projects\UpdateProjectRequest;
use Tessify\Core\Http\Requests\Projects\Teams\Applications\ApplyForTeamRoleRequest;

class ProjectService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;
    
    public function __construct()
    {
        $this->model = "Tessify\Core\Models\Project";
    }
    
    public function preload($instance)
    {
        // Convert header image url from relative to absolute (so it can be used in vue components)
        $instance->header_image_url = asset($instance->header_image_url);

        // Load the project's resources
        $instance->resources = ProjectResources::getAllPreloadedForProject($instance);

        // Load the project's team roles
        $instance->team_roles = TeamRoles::getAllPreloadedForProject($instance);

        // Load the project's status
        $instance->status = ProjectStatuses::findForProject($instance);

        // Load the project's author
        $instance->author = Users::findAuthorForProject($instance);

        // Load the project's category
        $instance->category = ProjectCategories::findForProject($instance);

        // Load the project's work method
        $instance->work_method = WorkMethods::findForProject($instance);

        // Load the project's team member applications
        $instance->team_member_applications = TeamMemberApplications::getAllForProject($instance);

        // Format the dates
        $instance->formatted_starts_at = is_null($instance->starts_at) ? null : $instance->starts_at->format("d-m-Y");
        $instance->formatted_ends_at = is_null($instance->ends_at) ? null : $instance->ends_at->format("d-m-Y");
        $instance->formatted_created_at = $instance->created_at->format("d-m-Y H:m:s");
        $instance->formatted_updated_at = $instance->updated_at->format("d-m-Y H:m:s");

        // Return the upgraded project
        return $instance;
    }

    public function findBySlug($slug)
    {
        foreach ($this->getAll() as $project)
        {
            if ($project->slug == $slug)
            {
                return $project;
            }
        }

        return false;
    }

    public function findPreloadedBySlug($slug)
    {
        foreach ($this->getAllPreloaded() as $project)
        {
            if ($project->slug == $slug)
            {
                return $project;
            }
        }

        return false;
    }

    public function createFromRequest(CreateProjectRequest $request)
    {
        $starts_at = Dates::parse($request->starts_at, "/");
        $ends_at = Dates::parse($request->ends_at, "/");

        $data = [
            "author_id" => Auth::user()->id,
            "project_status_id" => $request->project_status_id,
            "project_category_id" => $request->project_category_id,
            "work_method_id" => $request->work_method_id,
            "title" => $request->title,
            "slogan" => $request->slogan,
            "description" => $request->description,
            "starts_at" => $starts_at->format("Y-m-d"),
            "ends_at" => $ends_at->format("Y-m-d"),
        ];

        if ($request->hasFile("header_image"))
        {
            $data["header_image_url"] = Uploader::upload($request->file("header_image"), "images/projects/header");
        }

        $project = Project::create($data);

        $this->processProjectResources($project, $request->resources);
        $this->processTeamRoles($project, $request->team_roles);

        return $project;
    }
    
    public function updateFromRequest(Project $project, UpdateProjectRequest $request)
    {
        $starts_at = Dates::parse($request->starts_at, "/");
        $ends_at = Dates::parse($request->ends_at, "/");

        $project->project_status_id = $request->project_status_id;
        $project->project_category_id = $request->project_category_id;
        $project->work_method_id = $request->work_method_id;
        $project->title = $request->title;
        $project->slogan = $request->slogan;
        $project->description = $request->description;
        $project->starts_at = $starts_at->format("Y-m-d");
        $project->ends_at = $ends_at->format("Y-m-d");

        if ($request->hasFile("header_image"))
        {
            $project->header_image_url = Uploader::upload($request->file("header_image"), "images/projects/header");
        }

        $project->save();

        $this->processProjectResources($project, $request->resources);
        // $this->processTeamRoles($project, $request->team_roles);

        return $project;
    }

    private function processProjectResources(Project $project, $encodedResources)
    {
        // TODO: make this function smarter
        $project->resources()->delete();

        if (!is_null($encodedResources) and $encodedResources !== "" and $encodedResources !== "[]")
        {
            $resources = json_decode($encodedResources);
            if (is_array($resources) and count($resources))
            {
                foreach ($resources as $resource_id)
                {
                    $resource = ProjectResources::find($resource_id);
                    if ($resource)
                    {
                        $resource->project_id = $project->id;
                        $resource->save();
                    }
                }
            }
        }

        return $project;
    }

    private function processTeamRoles(Project $project, $encodedTeamRoles)
    {
        // TODO: make this function smarter; only delete those members that have actually been removed
        // so that existing team members don't lose their data. For MVP; delete that shiiiit.
        $project->teamRoles()->delete();

        if (!is_null($encodedTeamRoles) and $encodedTeamRoles !== "" and $encodedTeamRoles !== "[]")
        {
            $teamRoles = json_decode($encodedTeamRoles);
            if (is_array($teamRoles) and count($teamRoles))
            {
                foreach ($teamRoles as $teamRole)
                {
                    $skill_ids = [];
                    if (count($teamRole->skills))
                    {
                        foreach ($teamRole->skills as $skillName)
                        {
                            $skill = Skills::findOrCreateByName($skillName);
                            if ($skill) $skill_ids[] = $skill->id;
                        }
                    }

                    $tm = TeamRole::create([
                        "project_id" => $project->id,
                        "name" => $teamRole->name,
                        "description" => $teamRole->description
                    ]);
                    
                    if (count($skill_ids)) $tm->skills()->attach($skill_ids);
                }
            }
        }

        return $project;
    }

    public function processTeamApplication(Project $project, ApplyForTeamRoleRequest $request)
    {
        $user = Users::current();

        return TeamMemberApplication::create([
            "project_id" => $project->id,
            "user_id" => $user->id,
            "team_role_id" => $request->team_role_id,
            "motivation" => $request->motivation
        ]);
    }

    public function getResources(Project $project)
    {
        $out = ProjectResources::getAllPreloadedForProject($project);
        return collect($out);
    }

    public function getAuthor(Project $project)
    {
        return Users::findAuthorForProject($project);
    }

    public function getTeamMemberApplications(Project $project)
    {
        $applications = collect(TeamMemberApplications::getAllForProject($project));
        
        $applications->map(function($application) use ($project) {
            $application->view_href = route("projects.team.applications.view", ["slug" => $project->slug, "uuid" => $application->uuid]);
            return $application;
        });

        return $applications;
    }

    public function getMyTeamMemberApplications(Project $project)
    {
        $out = [];

        $user = Users::current();
        
        $applications = TeamMemberApplications::getAllForProject($project);
        foreach ($applications as $application)
        {
            if ($application->user_id == $user->id) $out[] = $application;
        }

        return collect($out);
    }

    public function getOutstandingRoles(Project $project)
    {
        $out = [];

        foreach ($project->teamRoles as $teamRole)
        {
            if ($teamRole->teamMembers->count() and $teamRole->teamMembers->count() == $teamRole->positions)
            {
                // dd($teamRole, $teamRole->teamMembers, $teamRole->teamMembers->count() == $teamRole->positions);
                continue;
            }
            
            $out[] = $teamRole;
        }

        return collect($out);
    }

    public function isTeamMember(User $user, Project $project)
    {
        if ($project->teamMembers->count())
        {
            foreach ($project->teamMembers as $teamMember)
            {
                if ($teamMember->user_id == $user->id)
                {
                    return true;
                }
            }
        }

        return false;
    }

    public function hasOutstandingTeamApplication(User $user, Project $project)
    {
        $applications = TeamMemberApplications::getAllForProject($project);

        if (count($applications))
        {
            foreach($applications as $application)
            {
                if ($application->user_id == $user->id)
                {
                    return true;
                }
            }
        }

        return false;
    }
}