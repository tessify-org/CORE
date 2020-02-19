<?php

namespace Tessify\Core\Http\Controllers\Projects;

use Projects;
use TeamMemberApplications;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Projects\Teams\Applications\CreateTeamMemberApplicationRequest;
use Tessify\Core\Http\Requests\Projects\Teams\Applications\UpdateTeamMemberApplicationRequest;
use Tessify\Core\Http\Requests\Projects\Teams\Applications\DeleteTeamMemberApplicationRequest;

class ProjectTeamMemberApplicationController extends Controller
{
    public function getOverview($slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        return view("tessify-core::pages.projects.teams.applications.overview", [
            "project" => $project,
            "applications" => Projects::getTeamMemberApplications($project),
            "myApplications" => Projects::getMyTeamMemberApplications($project),
        ]);
    }

    public function getView($slug, $uuid)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }
        
        $application = TeamMemberApplications::findByUuid($uuid);
        if (!$application)
        {
            flash(__("tessify-core::projects.application_not_found"))->error();
            return redirect()->route("projects", $project->slug);
        }

        return view("tessify-core::pages.projects.teams.applications.view", [
            "project" => $project,
            "application" => $application,
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
        
        return view("tessify-core::pages.projects.teams.applications.create", [
            "project" => $project,
            "roles" => Projects::getOutstandingRoles($project),
            "oldInput" => collect([
                "team_role_id" => old("team_role_id"),
                "motivation" => old("motivation"),
            ])
        ]);
    }

    public function postCreate(CreateTeamMemberApplicationRequest $request, $slug)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $application = TeamMemberApplications::createFromRequest($project, $request);

        flash(__("tessify-core::projects.apply_thanks"))->success();
        return redirect()->route("projects.view", $project->slug);
    }

    public function getEdit($slug, $uuid)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }
        
        $application = TeamMemberApplications::findByUuid($uuid);
        if (!$application)
        {
            flash(__("tessify-core::projects.application_not_found"))->error();
            return redirect()->route("projects", $project->slug);
        }

        return view("tessify-core::pages.projects.teams.applications.edit", [
            "project" => $project,
            "application" => $application,
            "roles" => Projects::getOutstandingRoles($project),
            "oldInput" => collect([
                "team_role_id" => old("team_role_id"),
                "motivation" => old("motivation"),
            ])
        ]);
    }

    public function postEdit(UpdateTeamMemberApplicationRequest $request, $slug, $uuid)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }
        
        $application = TeamMemberApplications::findByUuid($uuid);
        if (!$application)
        {
            flash(__("tessify-core::projects.application_not_found"))->error();
            return redirect()->route("projects", $project->slug);
        }

        $this->authorize("manage-team-member-application", $application);

        $application = TeamMemberApplications::updateFromRequest($application, $request);

        flash(__("tessify-core::general.saved_changes"))->success();
        return redirect()->route("projects.team.applications.view", ["slug" => $project->slug, "uuid" => $application->uuid]);
    }

    public function getDelete($slug, $uuid)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }
        
        $application = TeamMemberApplications::findByUuid($uuid);
        if (!$application)
        {
            flash(__("tessify-core::projects.application_not_found"))->error();
            return redirect()->route("projects", $project->slug);
        }

        return view("tessify-core::pages.projects.teams.applications.delete", [
            "project" => $project,
            "application" => $application,
        ]);
    }

    public function postDelete(DeleteTeamMemberApplicationRequest $request, $slug, $uuid)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }
        
        $application = TeamMemberApplications::findByUuid($uuid);
        if (!$application)
        {
            flash(__("tessify-core::projects.application_not_found"))->error();
            return redirect()->route("projects", $project->slug);
        }

        $this->authorize("manage-team-member-application", $application);

        $application->delete();

        flash(__("tessify-core::projects.delete_application_success"))->success();
        return redirect()->route("projects.team.applications", $project->slug);
    }

    public function getAccept($slug, $uuid)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }
        
        $this->authorize("manage-team-member-applications", $project);
        
        $application = TeamMemberApplications::findByUuid($uuid);
        if (!$application)
        {
            flash(__("tessify-core::projects.application_not_found"))->error();
            return redirect()->route("projects", $project->slug);
        }
        
        TeamMemberApplications::accept($application);

        flash(__("tessify-core::projects.application_accepted"))->success();
        return redirect()->route("projects.team.applications.view", ["slug" => $project->slug, "uuid" => $application->uuid]);
    }

    public function getReject($slug, $uuid)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }
        
        $this->authorize("manage-team-member-applications", $project);
        
        $application = TeamMemberApplications::findByUuid($uuid);
        if (!$application)
        {
            flash(__("tessify-core::projects.application_not_found"))->error();
            return redirect()->route("projects", $project->slug);
        }

        TeamMemberApplications::reject($application);

        flash(__("tessify-core::projects.application_rejected"))->success();
        return redirect()->route("projects.team.applications.view", ["slug" => $project->slug, "uuid" => $application->uuid]);
    }

    public function getReopen($slug, $uuid)
    {
        $project = Projects::findPreloadedBySlug($slug);
        if (!$project)
        {
            flash(__("tessify-core::projects.project_not_found"))->error();
            return redirect()->route("projects");
        }

        $this->authorize("manage-team-member-applications", $project);
        
        $application = TeamMemberApplications::findByUuid($uuid);
        if (!$application)
        {
            flash(__("tessify-core::projects.application_not_found"))->error();
            return redirect()->route("projects", $project->slug);
        }

        TeamMemberApplications::reopen($application);

        flash(__("tessify-core::projects.application_reopened"))->success();
        return redirect()->route("projects.team.applications.view", ["slug" => $project->slug, "uuid" => $application->uuid]);
    }
}