<?php

namespace Tessify\Core\Http\Controllers\System;

use Notifications;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function getOverview()
    {
        return view("pages.system.notifications.overview", [
            "notifications" => Notifications::get(),
        ]);
    }

    public function getClear()
    {
        Notifications::clear();

        flash(__("tessify-core::notifications.clear_success"))->success();
        return redirect()->route("notifications");
    }
}