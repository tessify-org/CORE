<?php

namespace Tessify\Core\Http\Controllers\Profiles;

use Auth;
use Users;
use Tasks;
use Skills;
use Comments;
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
use Tessify\Core\Events\User\UserFollowsUser;
use Tessify\Core\Events\User\UserUnfollowsUser;
use Tessify\Core\Http\Requests\Profiles\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function getProfile($slug = null)
    {
        // Grab the user this profile belongs to
        $user = is_null($slug) ? Auth::user() : User::where("slug", $slug)->first();
        if (!$user)
        {
            flash(__('tessify-core::profiles.user_not_found'))->error();
            return redirect()->route("memberlist");
        }

        // Determine some things
        $is_mine = $user->id == auth()->user()->id;
        $has_sent_view_email_request = $is_mine ? false : ViewEmailRequests::hasSentRequest($user);
        $has_accepted_view_email_request = $is_mine ? false : ViewEmailRequests::canViewEmail($user);
        $can_view_email = $user->publicly_display_email == true || $has_accepted_view_email_request == true;
        
        // Render the profile page
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
            "comments" => Comments::getAllPreloadedForUser($user),
        ]);
    }

    public function getUpdateProfile()
    {
        // Render the update profile page
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
        // Update the user's profile
        Users::updateProfileFromRequest($request);

        // Flash message & redirect to view profile page
        flash(__('tessify-core::general.saved_changes'))->success();
        return redirect()->route("profile");
    }

    public function getFollow($slug)
    {
        // Grab the user we want to follow
        $user = Users::findBySlug($slug);
        if (!$user)
        {
            flash(__('tessify-core::profiles.user_not_found'))->error();
            return redirect()->route("memberlist");
        }

        // Follow the user
        auth()->user()->follow($user);

        // Fire event
        event(new UserFollowsUser(auth()->user(), $user));

        // Flash message & redirect to the user's profile
        flash(__("tessify-core::followers.follow_success", ["user" => $user->formattedName]))->success();
        return redirect()->route("profile", $user->slug);
    }

    public function getUnfollow($slug)
    {
        // Grab the user we want to unfollow
        $user = Users::findBySlug($slug);
        if (!$user)
        {
            flash(__('tessify-core::profiles.user_not_found'))->error();
            return redirect()->route("memberlist");
        }

        // Unfollow the user
        Auth::user()->unfollow($user);

        // Fire event
        event(new UserUnfollowsUser(auth()->user(), $user));

        // Flash message & redirect to the user's profile
        flash(__("tessify-core::followers.unfollow_success", ["user" => $user->formattedName]))->success();
        return redirect()->route("profile", $user->slug);
    }

    public function getRequestAccessToEmail($slug)
    {
        // Grab the user we want to send the request to
        $user = Users::findBySlug($slug);
        if (!$user)
        {
            flash(__('tessify-core::profiles.user_not_found'))->error();
            return redirect()->route("memberlist");
        }

        // Send view email request to the target user
        ViewEmailRequests::sendRequest($user);

        // Flash message & redirect to the user's profile
        flash(__("tessify-core::profiles.profile_email_request_sent_message", ["name" => $user->formattedName]))->success();
        return redirect()->route("profile", $user->slug);
    }

    public function getAcceptAccessEmailRequest($messageUuid, $requestUuid)
    {
        // Grab the message containing the request
        $message = Messages::findByUuid($messageUuid);
        if (!$message)
        {
            flash(__("tessify-core::messages.message_not_found"))->error();
            return redirect()->back();
        }

        // Grab the request we want to accept
        $request = ViewEmailRequests::findByUuid($requestUuid);
        if (!$request)
        {
            flash(__("tessify-core::profiles.profile_email_request_not_found"))->error();
            return redirect()->back();
        }

        // Accept the view email request
        ViewEmailRequests::accept($message, $request);

        // Flash message & redirect back
        flash(__("tessify-core::profiles.profile_email_request_accepted"))->success();
        return redirect()->back();
    }

    public function getRejectAccessEmailRequest($messageUuid, $requestUuid)
    {
        // Grab the message containing the request
        $message = Messages::findByUuid($messageUuid);
        if (!$message)
        {
            flash(__("tessify-core::messages.message_not_found"))->error();
            return redirect()->back();
        }

        // Grab the request we want to reject
        $request = ViewEmailRequests::findByUuid($requestUuid);
        if (!$request)
        {
            flash(__("tessify-core::profiles.profile_email_request_not_found"))->error();
            return redirect()->back();
        }

        // Reject the request
        ViewEmailRequests::reject($message, $request);

        // Flash message & redirect back
        flash(__("tessify-core::profiles.profile_email_request_rejected"))->success();
        return redirect()->back();
    }
}