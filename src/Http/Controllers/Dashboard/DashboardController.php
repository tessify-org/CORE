<?php

namespace Tessify\Core\Http\Controllers\Dashboard;

use Auth;
use Users;
use Tasks;
use Projects;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function getDashboard()
    {
        // Grab logged in user
        $user = Auth::user();

        // Generate the greeting
        $now = now();
        if ($now->hour > 0 and $now->hour < 6) {
            $greeting = __("tessify-core::dashboard.greeting_morning", ["name" => $user->formattedName]);
        } elseif ($now->hour > 6 and $now->hour < 12) {
            $greeting = __("tessify-core::dashboard.greeting_afternoon", ["name" => $user->formattedName]);
        } elseif ($now->hour > 12 and $now->hour < 18) {
            $greeting = __("tessify-core::dashboard.greeting_evening", ["name" => $user->formattedName]);
        } else {
            $greeting = __("tessify-core::dashboard.greeting_night", ["name" => $user->formattedName]);
        }

        // Render the view
        return view("tessify-core::pages.dashboard.dashboard", [
            "user" => Users::current(),
            "numTasksCompleted" => Tasks::numCompletedForUser(),
            "numProjectsCompleted" => 0,
            "numReviewsPlaced" => 0,
            "myProjects" => Projects::getAllForUser(),
            "myTasks" => Tasks::getAllForUser(),
            "greeting" => $greeting,
        ]);
    }
}