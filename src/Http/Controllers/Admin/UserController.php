<?php

namespace Tessify\Core\Http\Controllers\Admin;

use Users;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Admin\Users\CreateUserRequest;
use Tessify\Core\Http\Requests\Admin\Users\UpdateUserRequest;
use Tessify\Core\Http\Requests\Admin\Users\DeleteUserRequest;

class UserController extends Controller
{
    public function getOverview()
    {
        return view("tessify-core::pages.admin.users.overview", [
            "users" => Users::getAllPreloaded(),
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
                "first_name" => old("first_name"),
                "last_name" => old("last_name"),
                "email" => old("email"),
            ])
        ]);
    }

    public function postCreate(CreateUserRequest $request)
    {
        $user = Users::createFromAdminRequest($request);

        flash(__())->success();
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
                "first_name" => old("first_name"),
                "last_name" => old("last_name"),
                "email" => old("email"),
            ])
        ]);
    }

    public function postEdit(UpdateUserRequest $request, $id)
    {
        $user = Users::findPreloaded($id);
        if (!$user)
        {
            flash(__("tessify-core::admin.user_not_found"))->error();
            return redirect()->route("admin.users");
        }
        
        $user = Users::uploadFromAdminRequest($user, $request);

        flash(__())->success();
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

        flash(__())->success();
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
        
    }

    public function getUnban($id)
    {
        $user = Users::findPreloaded($id);
        if (!$user)
        {
            flash(__("tessify-core::admin.user_not_found"))->error();
            return redirect()->route("admin.users");
        }

    }

    public function getFlagAsChecked($id)
    {
        $user = Users::findPreloaded($id);
        if (!$user)
        {
            flash(__("tessify-core::admin.user_not_found"))->error();
            return redirect()->route("admin.users");
        }
        
    }
}