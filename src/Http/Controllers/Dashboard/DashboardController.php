<?php

namespace Tessify\Core\Http\Controllers\Dashboard;

use Auth;
use Users;
use Tasks;
use Projects;
use Messages;
use Notifications;
use FeedActivities;
use ReviewRequests;
use ViewEmailRequests;
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
        
        // Subscriptions & followings
        $followings = $user->followings;
        $subscribedMinistries = $user->subscriptions()->withType("Tessify\\Core\\Models\\Ministry")->get();
        $subscribedOrganizations = $user->subscriptions()->withType("Tessify\\Core\\Models\\Organization")->get();
        $subscribedProjects = $user->subscriptions()->withType("Tessify\\Core\\Models\\Project")->get();
        $subscribedTasks = $user->subscriptions()->withType("Tessify\\Core\\Models\\Task")->get();

        // Render the view
        return view("tessify-core::pages.dashboard.dashboard", [
            "user" => Users::current(),
            "numTasksCompleted" => Tasks::numCompletedForUser(),
            "numProjectsCompleted" => 0,
            "numReviewsPlaced" => 0,
            "myProjects" => Projects::getAllForUser(),
            "myTasks" => Tasks::getAllForUser(),
            "greeting" => $greeting,
            "followings" => $this->prepareSubscriptionData("users", $followings),
            "subscribedTasks" => $this->prepareSubscriptionData("tasks", $subscribedTasks),
            "subscribedProjects" => $this->prepareSubscriptionData("projects", $subscribedProjects),
            "subscribedMinistries" => $this->prepareSubscriptionData("ministries", $subscribedMinistries),
            "subscribedOrganizations" => $this->prepareSubscriptionData("organizations", $subscribedOrganizations),
            "feedActivities" => FeedActivities::getFeed(),
            "numUnreadMessages" => Messages::numUnread(),
            "numUnreadNotifications" => Notifications::numUnread(),
            "numEmailRequests" => ViewEmailRequests::numRequests(),
            "numReviewRequests" => ReviewRequests::numRequests(),
        ]);
    }

    private function prepareSubscriptionData($type, $data)
    {
        $out = [];

        switch ($type)
        {
            case "users":
                foreach ($data as $entry)
                {
                    $out[] = [
                        "view_href" => route("profile", $entry->slug),
                        "text" => $entry->formatted_name,
                    ];
                }
            break;
            
            case "ministries":
                foreach ($data as $entry)
                {
                    $out[] = [
                        "view_href" => "#",
                        "text" => $entry->subscribable->name,
                    ];
                }
            break;
            
            case "organizations":
                foreach ($data as $entry)
                {
                    $out[] = [
                        "view_href" => "#",
                        "text" => $entry->subscribable->name,
                    ];
                }
            break;
            
            case "projects":
                foreach ($data as $entry)
                {
                    $out[] = [
                        "view_href" => route("projects.view", $entry->subscribable->slug),
                        "text" => $entry->subscribable->title,
                    ];
                }
            break;

            case "tasks":
                foreach ($data as $entry)
                {
                    $out[] = [
                        "view_href" => route("tasks.view", $entry->subscribable->slug),
                        "text" => $entry->subscribable->title,
                    ];
                }
            break;
        }

        return collect($out);
    }
}