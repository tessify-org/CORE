<?php

namespace Tessify\Core\Http\Controllers\Admin;

use Users;
use Messages;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Admin\Users\BanUserRequest;
use Tessify\Core\Http\Requests\Admin\Users\CreateUserRequest;
use Tessify\Core\Http\Requests\Admin\Users\UpdateUserRequest;
use Tessify\Core\Http\Requests\Admin\Users\DeleteUserRequest;
use Tessify\Core\Http\Requests\Admin\Users\SendMessageRequest;
use Tessify\Core\Http\Requests\Admin\Users\ChangePasswordRequest;

class UserController extends Controller
{
    public function getOverview()
    {
        $users = Users::getAllPreloaded();
        $users->map(function($user) {
            $user->view_href = route("admin.users.view", $user->id);
            return $user;
        });

        return view("tessify-core::pages.admin.users.overview", [
            "users" => $users,
            "fields" => collect([
                [
                    "field" => "formatted_name",
                    "label" => __("tessify-core::admin.users_overview_name"),
                ],
                [
                    "field" => "email",
                    "label" => __("tessify-core::admin.users_overview_email"),
                ],
                [
                    "field" => "formatted_has_been_checked",
                    "label" => __("tessify-core::admin.users_overview_checked")
                ]
            ])
        ]);
    }

    public function getView($id)
    {
        $user = Users::findPreloaded($id);
        if (!$user)
        {
            flash(__("tessify-core::admin.user_not_found"))->error();
            return redirect()->route("admin.users");
        }

        return view("tessify-core::pages.admin.users.view", [
            "user" => $user,
        ]);
    }

    public function getCreate() 
    {
        return view("tessify-core::pages.admin.users.create", [
            "oldInput" => collect([
                "annotation" => old("annotation"),
                "first_name" => old("first_name"),
                "last_name" => old("last_name"),
                "email" => old("email"),
            ])
        ]);
    }

    public function postCreate(CreateUserRequest $request)
    {
        $user = Users::createFromAdminRequest($request);

        flash(__("tessify-core::admin.user_created"))->success();
        return redirect()->route("admin.users.view", $user->id);
    }

    public function getEdit($id)
    {
        $user = Users::findPreloaded($id);
        if (!$user)
        {
            flash(__("tessify-core::admin.user_not_found"))->error();
            return redirect()->route("admin.users");
        }

        return view("tessify-core::pages.admin.users.edit", [
            "user" => $user,
            "oldInput" => collect([
                "annotation" => old("annotation"),
                "first_name" => old("first_name"),
                "last_name" => old("last_name"),
                "email" => old("email"),
            ])
        ]);
    }

    public function postEdit(UpdateUserRequest $request, $id)
    {
        $user = Users::find($id);
        if (!$user)
        {
            flash(__("tessify-core::admin.user_not_found"))->error();
            return redirect()->route("admin.users");
        }
        
        $user = Users::updateFromAdminRequest($user, $request);

        flash(__("tessify-core::admin.user_updated"))->success();
        return redirect()->route("admin.users.view", $user->id);
    }

    public function getDelete($id)
    {
        $user = Users::findPreloaded($id);
        if (!$user)
        {
            flash(__("tessify-core::admin.user_not_found"))->error();
            return redirect()->route("admin.users");
        }
        
        return view("tessify-core::pages.admin.users.delete", [
            "user" => $user,
        ]);
    }

    public function postDelete(DeleteUserRequest $request, $id)
    {
        $user = Users::findPreloaded($id);
        if (!$user)
        {
            flash(__("tessify-core::admin.user_not_found"))->error();
            return redirect()->route("admin.users");
        }

        $user->delete();

        flash(__("tessify-core::admin.user_deleted"))->success();
        return redirect()->route("admin.users");
    }

    public function getBan($id)
    {
        $user = Users::findPreloaded($id);
        if (!$user)
        {
            flash(__("tessify-core::admin.user_not_found"))->error();
            return redirect()->route("admin.users");
        }

        return view("tessify-core::pages.admin.users.ban", [
            "user" => $user,
            "oldInput" => collect([
                "type" => old("type"),
                "duration" => old("duration"),
            ])
        ]);
    }

    public function postBan(BanUserRequest $request, $id)
    {
        $user = Users::find($id);
        if (!$user)
        {
            flash(__("tessify-core::admin.user_not_found"))->error();
            return redirect()->route("admin.users");
        }

        if ($request->type == "permanent") {
            Users::banPermanently($user);
        } else {
            Users::banTemporarily($request->duration, $user);
        }

        flash(__("tessify-core::admin.user_banned"))->success();
        return redirect()->route("admin.users.view", $user->id);
    }

    public function getUnban($id)
    {
        $user = Users::find($id);
        if (!$user)
        {
            flash(__("tessify-core::admin.user_not_found"))->error();
            return redirect()->route("admin.users");
        }

        Users::unban($user);

        flash(__("tessify-core::admin.user_unbanned"))->success();
        return redirect()->route("admin.users.view", $user->id);
    }

    public function getFlagAsChecked($id)
    {
        $user = Users::find($id);
        if (!$user)
        {
            flash(__("tessify-core::admin.user_not_found"))->error();
            return redirect()->route("admin.users");
        }

        Users::flagAsChecked($user);

        flash(__("tessify-core::admin.user_flagged_as_checked"))->success();
        return redirect()->route("admin.users.view", $user->id);
    }

    public function getFlagAsUnchecked($id)
    {
        $user = Users::find($id);
        if (!$user)
        {
            flash(__("tessify-core::admin.user_not_found"))->error();
            return redirect()->route("admin.users");
        }

        Users::flagAsUnchecked($user);

        flash(__("tessify-core::admin.user_unflagged_as_checked"))->success();
        return redirect()->route("admin.users.view", $user->id);
    }

    public function getChangePassword($id)
    {
        $user = Users::findPreloaded($id);
        if (!$user)
        {
            flash(__("tessify-core::admin.user_not_found"))->error();
            return redirect()->route("admin.users");
        }

        return view("tessify-core::pages.admin.users.change-password", [
            "user" => $user,
            "strings" => collect([
                "new_password" => __("tessify-core::admin.users_change_password_new_password"),
                "confirm_new_password" => __("tessify-core::admin.users_change_password_confirm_new_password"),
            ])
        ]);
    }

    public function postChangePassword(ChangePasswordRequest $request, $id)
    {
        $user = Users::find($id);
        if (!$user)
        {
            flash(__("tessify-core::admin.user_not_found"))->error();
            return redirect()->route("admin.users");
        }

        $user->password = bcrypt($request->password);
        $user->save();

        flash(__("tessify-core::admin.users_password_changed"))->success();
        return redirect()->route("admin.users.view", $id);
    }

    public function getSendMessage($id)
    {
        $user = Users::findPreloaded($id);
        if (!$user)
        {
            flash(__("tessify-core::admin.user_not_found"))->error();
            return redirect()->route("admin.users");
        }

        return view("tessify-core::pages.admin.users.send-message", [
            "user" => $user,
            "strings" => collect([
                "user" => __("tessify-core::admin.users_send_message_user"),
                "subject" => __("tessify-core::admin.users_send_message_subject"),
                "message" => __("tessify-core::admin.users_send_message_message"),
            ]),
            "oldInput" => collect([
                "subject" => old("subject"),
                "message" => old("message"),
            ]),
        ]);
    }
    
    public function postSendMessage(SendMessageRequest $request, $id)
    {
        $user = Users::findPreloaded($id);
        if (!$user)
        {
            flash(__("tessify-core::admin.user_not_found"))->error();
            return redirect()->route("admin.users");
        }

        Messages::sendMessageFromAdminRequest($user, $request);

        flash(__("tessify-core::admin.users_message_sent"))->success();
        return redirect()->route("admin.users.view", $id);
    }
}