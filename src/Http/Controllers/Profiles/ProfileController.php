<?php

namespace Tessify\Core\Http\Controllers\Profiles;

use Auth;
use Users;
use Skills;
use Assignments;
use AssignmentTypes;
use Organizations;
use OrganizationLocations;
use OrganizationDepartments;
use App\Models\User;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Profiles\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function getProfile($slug = null)
    {
        $user = is_null($slug) ? Auth::user() : User::where("slug", $slug)->first();
        if (!$user)
        {
            flash(__('tessify-core::profiles.user_not_found'))->error();
            return redirect()->route("memberlist");
        }

        return view("tessify-core::pages.profiles.profile", [
            "user" => $user,
            "followers" => Users::getFollowers($user),
            "following" => Users::getFollowing($user),
            "assignments" => Assignments::findAllPreloadedForUser($user),
        ]);
    }

    public function getUpdateProfile()
    {
        return view("tessify-core::pages.profiles.update-profile", [
            "user" => Users::current(),
            "skills" => Skills::getAll(),
            "assignmentTypes" => AssignmentTypes::getAll(),
            "organizations" => Organizations::getAll(),
            "departments" => OrganizationDepartments::getAll(),
            "organizationLocations" => OrganizationLocations::getAll(),
            "oldInput" => collect([
                "first_name" => old("first_name"),
                "last_name" => old("last_name"),
                "headline" => old("headline"),
                "interests" => old("interests"),
                "email" => old("email"),
                "phone" => old("phone"),
                "current_assignment_id" => old("current_assignment_id"),
                "skills" => old("skills"),
            ]),
        ]);
    }

    public function postUpdateProfile(UpdateProfileRequest $request)
    {
        Users::updateProfileFromRequest($request);

        flash(__('tessify-core::general.saved_changes'))->success();
        return redirect()->route("profile");
    }

    public function getFollow($slug)
    {
        $user = Users::findBySlug($slug);
        if (!$user)
        {
            flash(__('tessify-core::profiles.user_not_found'))->error();
            return redirect()->route("memberlist");
        }

        Auth::user()->follow($user);

        flash(__("tessify-core::followers.follow_success", ["user" => $user->formattedName]))->success();
        return redirect()->route("profile", $user->slug);
    }

    public function getUnfollow($slug)
    {
        $user = Users::findBySlug($slug);
        if (!$user)
        {
            flash(__('tessify-core::profiles.user_not_found'))->error();
            return redirect()->route("memberlist");
        }

        Auth::user()->unfollow($user);

        flash(__("tessify-core::followers.unfollow_success", ["user" => $user->formattedName]))->success();
        return redirect()->route("profile", $user->slug);
    }
}