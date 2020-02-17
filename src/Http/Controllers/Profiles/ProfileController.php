<?php

namespace Tessify\Core\Http\Controllers\Profiles;

use Auth;
use Users;
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
        ]);
    }

    public function getUpdateProfile()
    {
        return view("tessify-core::pages.profiles.update-profile", [
            "user" => Auth::user(),
            "oldInput" => collect([
                "annotation" => old("annotation"),
                "first_name" => old("first_name"),
                "last_name" => old("last_name"),
                "email" => old("email"),
                "phone" => old("phone"),
                "current_assignment_id" => old("current_assignment_id"),
            ]),
        ]);
    }

    public function postUpdateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $user->annotation = $request->annotation;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        flash(__('tessify-core::general.saved_changes'))->success();
        return redirect()->route("profile");
    }
}