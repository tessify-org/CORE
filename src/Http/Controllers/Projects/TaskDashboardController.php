<?php

namespace Tessify\Core\Http\Controllers\Projects;

use Tasks;
use TaskStatuses;
use TaskCategories;
use TaskSeniorities;
use App\Http\Controllers\Controller;

class TaskDashboardController extends Controller
{
    public function getOverview()
    {
        return view("tessify-core::pages.task-dashboard.overview", [
            "tasks" => Tasks::getAllPreloaded(),
            "statuses" => TaskStatuses::getAll(),
            "categories" => TaskCategories::getAll(),
            "seniorities" => TaskSeniorities::getAll(),
        ]);
    }
}