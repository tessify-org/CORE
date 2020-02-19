<?php

namespace Tessify\Core\Policies;

use App\Models\User;
use Tessify\Core\Models\TeamMemberApplication;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamMemberApplicationPolicy
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
     * Determine if the user can manage (edit & delete) a given team member application
     * 
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project   $project
     * @return mixed
     */
    public function manageTeamMemberApplication(User $user, TeamMemberApplication $application)
    {
        return $application->user_id == $user->id
            ? Reponse::accept()
            : Reponse::deny("You don't own this application.");
    }
}