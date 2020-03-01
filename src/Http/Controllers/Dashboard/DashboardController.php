<?php

namespace Tessify\Core\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function getDashboard()
    {
        return view("tessify-core::pages.dashboard.dashboard", [

        ]);
    }
}