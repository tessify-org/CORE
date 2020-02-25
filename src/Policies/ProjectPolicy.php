<?php

namespace Tessify\Core\Policies;

use Projects;
use App\Models\User;
use Tessify\Core\Models\Project;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * If the user is an administrator, give him/her full access
     *
     * @param  \App\Models\User  $user
     * @return true|void
     */
    public function before(User $user)
    {
        if ($user->is_admin) return true;
    }

    /**
     * Determine whether the user can view any jobs.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the job.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project   $project
     * @return mixed
     */
    public function view(User $user, Project $project)
    {
        return true;
    }

    /**
     * Determine whether the user can create jobs.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the job.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project   $project
     * @return mixed
     */
    public function update(User $user, Project $project)
    {
        return $project->author_id == $user->id
            ? Response::allow()
            : Response::deny(__("tessify-core::policies.update_deny"));
    }

    /**
     * Determine whether the user can delete the job.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project   $project
     * @return mixed
     */
    public function delete(User $user, Project $project)
    {
        return $project->author_id == $user->id
            ? Response::allow()
            : Response::deny(__("tessify-core::policies.delete_deny"));
    }

    /**
     * Determine whether the user can update this job's status.
     * 
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project   $project
     * @return mixed
     */
    public function updateStatus(User $user, Project $project)
    {
        return $project->author_id == $user->id
            ? Response::allow()
            : Response::deny(__("tessify-core::policies.status_deny"));
    }

    /**
     * Determine whether the user can manage this job's team roles.
     * 
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project   $project
     * @return mixed
     */
    public function manageTeamRoles(User $user, Project $project)
    {
        return $project->author_id == $user->id
            ? Response::allow()
            : Response::deny(__("tessify-core::policies.manage_team_roles_deny"));
    }

    /**
     * Determine whether the user can manage this job's team role applications.
     * 
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project   $project
     * @return mixed
     */
    public function manageTeamMemberApplications(User $user, Project $project)
    {
        return $project->author_id == $user->id
            ? Response::allow()
            : Response::deny(__("tessify-core::policies.manage_team_applications_deny"));
    }

    /**
     * Determine whether the user can manage this job's team members.
     * 
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project   $project
     * @return mixed
     */
    public function manageTeamMembers(User $user, Project $project)
    {
        return $project->author_id == $user->id
            ? Response::allow()
            : Response::deny(__("tessify-core::policies.manage_team_members_deny"));
    }

    /**
     * Determine whether the user can apply for team roles on this job.
     * 
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project   $project
     * @return mixed
     */
    public function applyForTeam(User $user, Project $project)
    {
        // Make sure the user is not the author
        if ($project->author_id == $user->id)
        {
            return Response::deny(__("tessify-core::policies.apply_for_team_deny_owner"));
        }

        // Make sure the user is not already a team member
        if (Projects::isTeamMember($project, $user))
        {
            return Response::deny(__("tessify-core::policies.apply_for_team_deny_team_member"));
        }
        
        // Make sure the user does not already have an outstanding application
        if (Projects::hasOutstandingTeamApplication($user, $project))
        {
            return Response::deny(__("tessify-core::policies.apply_for_team_deny_application_exists"));
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can leave the team of a given project.
     * 
     * @param  \App\Models\User     $user
     * @param  \App\Models\Project  $project
     * @return mixed
     */
    public function leaveTeam(User $user, Project $project)
    {
        return Projects::isTeamMember($project, $user)
            ? Response::allow()
            : Response::deny(__("tessify-core::policies.leave_team_deny"));
    }
}
