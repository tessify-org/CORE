<?php

namespace Tessify\Core\Http\Controllers\Profiles;

use Auth;
use Users;
use Tasks;
use Skills;
use Projects;
use Messages;
use Reputation;
use Assignments;
use Organizations;
use AssignmentTypes;
use ViewEmailRequests;
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

        $is_mine = $user->id == auth()->user()->id;
        $has_sent_view_email_request = $is_mine ? false : ViewEmailRequests::hasSentRequest($user);
        $has_accepted_view_email_request = $is_mine ? false : ViewEmailRequests::canViewEmail($user);
        $can_view_email = $user->publicly_display_email == true || $has_accepted_view_email_request == true;
        
        return view("tessify-core::pages.profiles.profile", [
            "user" => $user,
            "is_mine" => $is_mine,
            "has_sent_view_email_request" => $has_sent_view_email_request,
            "can_view_email" => $can_view_email,
            "followers" => Users::getFollowers($user),
            "following" => Users::getFollowing($user),
            "assignments" => Assignments::findAllPreloadedForUser($user),
            "projects" => Projects::getAllOngoingForUser($user),
            "tasks" => Tasks::getAllOngoingForUser($user),
            "transactions" => Reputation::getTransactionsForUser($user),
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
                "publicly_display_email" => old("publicly_display_email"),
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

    public function getRequestAccessToEmail($slug)
    {
        $user = Users::findBySlug($slug);
        if (!$user)
        {
            flash(__('tessify-core::profiles.user_not_found'))->error();
            return redirect()->route("memberlist");
        }

        ViewEmailRequests::sendRequest($user);

        flash(__("tessify-core::profiles.profile_email_request_sent_message", ["name" => $user->formattedName]))->success();
        return redirect()->route("profile", $user->slug);
    }

    public function getAcceptAccessEmailRequest($messageUuid, $requestUuid)
    {
        $message = Messages::findByUuid($messageUuid);
        if (!$message)
        {
            flash(__("tessify-core::messages.message_not_found"))->error();
            return redirect()->back();
        }

        $request = ViewEmailRequests::findByUuid($requestUuid);
        if (!$request)
        {
            flash(__("tessify-core::profiles.profile_email_request_not_found"))->error();
            return redirect()->back();
        }

        ViewEmailRequests::accept($message, $request);

        flash(__("tessify-core::profiles.profile_email_request_accepted"))->success();
        return redirect()->back();
    }

    public function getRejectAccessEmailRequest($messageUuid, $requestUuid)
    {
        $message = Messages::findByUuid($messageUuid);
        if (!$message)
        {
            flash(__("tessify-core::messages.message_not_found"))->error();
            return redirect()->back();
        }

        $request = ViewEmailRequests::findByUuid($requestUuid);
        if (!$request)
        {
            flash(__("tessify-core::profiles.profile_email_request_not_found"))->error();
            return redirect()->back();
        }

        ViewEmailRequests::reject($message, $request);

        flash(__("tessify-core::profiles.profile_email_request_rejected"))->success();
        return redirect()->back();
    }
}