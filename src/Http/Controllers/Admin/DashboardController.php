<?php

namespace Tessify\Core\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function getDashboard()
    {
        return view("tessify-core::pages.admin.dashboard");
    }
}