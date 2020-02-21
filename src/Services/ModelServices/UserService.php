<?php

namespace Tessify\Core\Services\ModelServices;

use Auth;
use Uuid;
use Projects;
use Carbon\Carbon;
use App\Models\User;
use Tessify\Core\Models\Project;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;
use Tessify\Core\Projects\Auth\SendAccountRecoveryEmail;
use Tessify\Core\Http\Requests\Auth\ResetPasswordRequest;
use Tessify\Core\Http\Requests\Profiles\UpdateProfileRequest;

class UserService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;

    public function __construct()
    {
        $this->model = "App\Models\User";
    }

    public function current()
    {
        $user = Auth::user();
        if ($user)
        {
            return $this->findPreloaded($user->id);
        }

        return false;
    }

    public function preload($instance)
    {
        // Add link to the user's profile page
        $instance->profile_href = route("profile", $instance->slug);
        
        // Manually load the dynamic attributes
        $instance->formatted_name = $instance->formattedName;
        $instance->combined_name = $instance->combined_name;

        // TODO: load relationships.. not necessary yet

        // Return the upgraded user
        return $instance;
    }

    public function getAllNotInProjectTeam(Project $project)
    {
        $out = [];

        foreach ($this->getAllPreloaded() as $user)
        {
            if (!Projects::isTeamMember($user, $project))
            {
                $out[] = $user;
            }
        }

        return collect($out);
    }

    public function findAuthorForProject(Project $project)
    {
        foreach ($this->getAllPreloaded() as $user)
        {
            if ($user->id == $project->author_id)
            {
                return $user;
            }
        }

        return false;
    }

    public function findUserByEmail($email)
    {
        foreach ($this->getAll() as $user)
        {
            if ($user->email == $email)
            {
                return $user;
            }
        }

        return false;
    }

    public function findBySlug($slug)
    {
        foreach ($this->getAll() as $user)
        {
            if ($user->slug == $slug)
            {
                return $user;
            }
        }

        return false;
    }

    public function findPreloadedBySlug($slug)
    {
        foreach ($this->getAllPreloaded() as $user)
        {
            if ($user->slug == $slug)
            {
                return $user;
            }
        }

        return false;
    }

    public function saveAvatar($id, $url)
    {
        $user = User::find($id);
        $user->avatar_url = $url;
        $user->save();
        return $user;
    }

    public function sendRecoverAccountEmail($email)
    {
        $user = $this->findUserByEmail($email);
        
        $user->recovery_code = Uuid::generate();
        $user->save();

        SendAccountRecoveryEmail::dispatch($user)->onQueue("emails");
    }

    public function emailExists($email)
    {
        return User::where("email", $email)->first() ? true : false;
    }

    public function recoveryCodeIsValid($email, $code)
    {
        $user = $this->findUserByEmail($email);
        if ($user and $user->recovery_code == $code)
        {
            return true;
        }
        return false;
    }

    public function resetPassword(User $user, ResetPasswordRequest $request)
    {
        $user->password = bcrypt($request->password);
        $user->save();
        return $user;
    }
}