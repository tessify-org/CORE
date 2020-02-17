<?php

namespace Tessify\Core\Policies;

use Tessify\Core\Models\User;
use Tessify\Core\Models\Job;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
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
        if ($user->is_admin)
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view any jobs.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        // Every logged in user can view any job
        return true;
    }

    /**
     * Determine whether the user can view the job.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job  $job
     * @return mixed
     */
    public function view(User $user, Job $job)
    {
        // Any user can view any job
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
        // Any user can create a job
        return true;
    }

    /**
     * Determine whether the user can update the job.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job  $job
     * @return mixed
     */
    public function update(User $user, Job $job)
    {
        // Only the job's author can update the job
        return $job->author_id == $user->id
            ? Response::allow()
            : Response::deny("Alleen de eigenaar kan dit project aanpassen.");
    }

    /**
     * Determine whether the user can delete the job.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job  $job
     * @return mixed
     */
    public function delete(User $user, Job $job)
    {
        return $job->author_id == $user->id
            ? Response::allow()
            : Response::deny("Alleen de eigenaar kan dit project verwijderen.");
    }

    /**
     * Determine whether the user can update this job's status.
     * 
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job  $job
     * @return mixed
     */
    public function updateStatus(User $user, Job $job)
    {
        return $job->author_id == $user->id
            ? Response::allow()
            : Response::deny("Alleen de eigenaar kan de status wijzigen.");
    }

    /**
     * Determine whether the user can manage this job's team roles.
     * 
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job  $job
     * @return mixed
     */
    public function manageTeamRoles(User $user, Job $job)
    {
        return $job->author_id == $user->id
            ? Response::allow()
            : Response::deny("Alleen de eigenaar kan team rollen managen.");
    }

    /**
     * Determine whether the user can apply for team roles on this job.
     * 
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job  $job
     * @return mixed
     */
    public function apply(User $user, Job $job)
    {
        return true;
    }

    /**
     * Determine whether the user can manage this job's team role applications.
     * 
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job  $job
     * @return mixed
     */
    public function manageApplications(User $user, Job $job)
    {
        return $job->author_id == $user->id
            ? Response::allow()
            : Response::deny("Alleen de eigenaar kan aanmeldingen managen.");
    }

    /**
     * Determine whether the user can manage this job's team members.
     * 
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job  $job
     * @return mixed
     */
    public function manageTeamMembers(User $user, Job $job)
    {
        return $job->author_id == $user->id
            ? Response::allow()
            : Response::deny("Alleen de eigenaar kan team leden managen.");
    }
}
