<?php

namespace Tessify\Core\Http\Controllers\Dashboard;

use Users;
use Tasks;
use Projects;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function getDashboard()
    {
        return view("tessify-core::pages.dashboard.dashboard", [
            "user" => Users::current(),
            "numTasksCompleted" => Tasks::numCompletedForUser(),
            "numProjectsCompleted" => 0,
            "numReviewsPlaced" => 0,
            "myProjects" => Projects::getAllForUser(),
            "myTasks" => Tasks::getAllForUser(),
        ]);
    }
}