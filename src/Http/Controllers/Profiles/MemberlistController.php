<?php

namespace Tessify\Core\Http\Controllers\Profiles;

use Users;
use Memberlist;
use App\Http\Controllers\Controller;

class MemberlistController extends Controller
{
    public function getMemberlist()
    {
        return view("tessify-core::pages.profiles.memberlist", [
            "users" => Users::getAllPreloaded(),
        ]);
    }
}