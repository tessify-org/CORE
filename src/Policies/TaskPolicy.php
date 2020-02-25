<?php

namespace Tessify\Core\Policies;

use Projects;
use App\Models\User;
use Tessify\Core\Models\TeamMemberApplication;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
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

    public function update(User $user, Task $task)
    {

    }

    public function delete(User $user, Task $task)
    {

    }

    public function assignSelf(User $user, Task $task)
    {

    }

    public function unassignSelf(User $user, Task $task)
    {
        
    }
}