<?php

namespace Tessify\Core\Http\Controllers\System;

use Notifications;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function getOverview()
    {
        Notifications::markAllAsRead();
        
        return view("tessify-core::pages.system.notifications.overview", [
            "notifications" => Notifications::get(),
        ]);
    }

    public function getClear()
    {
        Notifications::clear();
        
        flash(__("tessify-core::pages.system.notifications.cleared"))->success();
        return redirect()->route("notifications");
    }
}