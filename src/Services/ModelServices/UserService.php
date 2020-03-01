<?php

namespace Tessify\Core\Services\ModelServices;

use Auth;
use Uuid;
use Skills;
use Projects;
use Uploader;
use Assignments;
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
        $instance->skills = Skills::getAllForUser($instance);
        $instance->assignments = Assignments::findAllPreloadedForUser($instance);

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

    public function updateProfileFromRequest(UpdateProfileRequest $request, User $user = null)
    {
        // Grab the user
        if (is_null($user)) $user = Auth::user();

        // Update the user's direct attributes
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->headline = $request->headline;
        $user->interests = $request->interests;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->hasFile("avatar")) $user->avatar_url = Uploader::upload($request->file("avatar"), "images/users/avatars");
        if ($request->hasFile("header_bg")) $user->header_bg_url = Uploader::upload($request->file("header_bg"), "images/users/headers");
        $user->save();

        // Process assignments
        if ($request->current_assignment_id !== "0")
        {
            $assignment = Assignments::find($request->current_assignment_id);

            if (!$assignment->current)
            {
                Assignments::deactiveAllForUser($user);

                $assignment->current = true;
                $assignment->save();
            }
        }

        // Process skills
        if ($request->skills !== "[]")
        {
            $skills = json_decode($request->skills);
            if (is_array($skills) and count($skills))
            {
                $user->skills()->detach();

                foreach ($skills as $skillData)
                {
                    $skill = Skills::findOrCreateByName($skillData->skill);

                    $user->skills()->attach($skill->id, [
                        "mastery" => $skillData->mastery,
                        "description" => $skillData->description,
                    ]);
                }
            }
        }

        return $user;
    }

    public function getFollowers(User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        $out = [];

        foreach ($user->followers()->get() as $u)
        {
            $out[] = $this->preload($u);
        }

        return collect($out);
    }

    public function getFollowing(User $user = null)
    {
        if (is_null($user)) $user = Auth::user();

        $out = [];

        foreach ($user->followings(User::class)->get() as $u)
        {
            $out[] = $this->preload($u);
        }

        return collect($out);
    }
}