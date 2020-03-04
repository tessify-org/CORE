<?php

namespace Tessify\Core\Providers;

use Auth;

use Tessify\Core\Services\Utilities\DateService;
use Tessify\Core\Services\Utilities\UploadService;
use Tessify\Core\Services\Utilities\ReputationService;
use Tessify\Core\Services\ModelServices\UserService;
use Tessify\Core\Services\ModelServices\TaskService;
use Tessify\Core\Services\ModelServices\SkillService;
use Tessify\Core\Services\ModelServices\ProjectService;
use Tessify\Core\Services\ModelServices\CommentService;
use Tessify\Core\Services\ModelServices\TeamRoleService;
use Tessify\Core\Services\ModelServices\TaskStatusService;
use Tessify\Core\Services\ModelServices\TaskCategoryService;
use Tessify\Core\Services\ModelServices\TaskSeniorityService;
use Tessify\Core\Services\ModelServices\TeamMemberService;
use Tessify\Core\Services\ModelServices\WorkMethodService;
use Tessify\Core\Services\ModelServices\ProjectStatusService;
use Tessify\Core\Services\ModelServices\ProjectCategoryService;
use Tessify\Core\Services\ModelServices\ProjectResourceService;
use Tessify\Core\Services\ModelServices\TeamMemberApplicationService;
use Tessify\Core\Services\ModelServices\AssignmentService;
use Tessify\Core\Services\ModelServices\AssignmentTypeService;
use Tessify\Core\Services\ModelServices\MinistryService;
use Tessify\Core\Services\ModelServices\OrganizationService;
use Tessify\Core\Services\ModelServices\OrganizationTypeService;
use Tessify\Core\Services\ModelServices\OrganizationLocationService;
use Tessify\Core\Services\ModelServices\OrganizationDepartmentService;
use Tessify\Core\Services\ModelServices\NotificationService;
use Tessify\Core\Services\ModelServices\MessageService;
use Tessify\Core\Services\ModelServices\TaskProgressReportService;
use Tessify\Core\Services\ModelServices\TaskProgressReportReviewService;
use Tessify\Core\Services\ModelServices\TaskProgressReportAttachmentService;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    // Define policies
    protected $policies = [
        "Tessify\Core\Models\Task" => "Tessify\Core\Policies\TaskPolicy",
        "Tessify\Core\Models\Project" => "Tessify\Core\Policies\ProjectPolicy",
        "Tessify\Core\Models\TeamMemberApplication" => "Tessify\Core\Policies\TeamMemberApplicationPolicy",
    ];

    public function boot()
    {
        // Register the service provider responsible for the package's routes
        $this->app->register("Tessify\Core\Providers\CoreRouteServiceProvider");

        // Load the language files
        $this->loadTranslationsFrom(__DIR__."/../../resources/lang", "tessify-core");

        // Load the views
        $this->loadViewsFrom(__DIR__."/../../resources/views", "tessify-core");

        // Setup integration & publishing of the config file
        $this->mergeConfigFrom(__DIR__."/../../config/config.php", "tessify-core");
        $this->publishes([
            __DIR__."/../../config/config.php" => config_path("tessify-core.php"),
            __DIR__."/../../config/breadcrumbs.php" => config_path("breadcrumbs.php"),
        ], "config");

        // Define the authorization Gates
        $this->defineGates();

        // Register the package's policies
        $this->registerPolicies();

        // Compose views
        $this->composeViews();

        // Database related publishing
        $this->publishes([
            __DIR__."/../Database/migrations" => database_path("migrations"),
            __DIR__."/../Database/seeders" => database_path("seeders"),
        ], "db");

        // View publishing
        $this->publishes([__DIR__."/../../resources/views", resource_path("views/vendor/core")], "views");

        // Vue component publishing
        $this->publishes([__DIR__."/../../resources/js/components" => resource_path("js/components/core")], "components");

        // Stylesheet publishing
        $this->publishes([__DIR__."/../../resources/sass" => resource_path("sass")], "scss");
    }

    public function register()
    {
        $this->registerServices();
    }

    private function registerServices()
    {
        //
        // Register Model Services
        //

        $this->app->singleton("users", function() {
            return new UserService;
        });

        $this->app->singleton("skills", function() {
            return new SkillService;
        });

        $this->app->singleton("projects", function() {
            return new ProjectService;
        });

        $this->app->singleton("project-statuses", function() {
            return new ProjectStatusService;
        });

        $this->app->singleton("project-categories", function() {
            return new ProjectCategoryService;
        });

        $this->app->singleton("project-resources", function() {
            return new ProjectResourceService;
        });

        $this->app->singleton("work-methods", function() {
            return new WorkMethodService;
        });

        $this->app->singleton("tasks", function() {
            return new TaskService;
        });

        $this->app->singleton("task-statuses", function() {
            return new TaskStatusService;
        });

        $this->app->singleton("task-categories", function() {
            return new TaskCategoryService;
        });

        $this->app->singleton("task-seniorities", function() {
            return new TaskSeniorityService;
        });

        $this->app->singleton("team-members", function() {
            return new TeamMemberService;
        });

        $this->app->singleton("team-member-applications", function() {
            return new TeamMemberApplicationService;
        });

        $this->app->singleton("team-roles", function() {
            return new TeamRoleService;
        });

        $this->app->singleton("comments", function() {
            return new CommentService;
        });

        $this->app->singleton("assignments", function() {
            return new AssignmentService;
        });

        $this->app->singleton("assignment-types", function() {
            return new AssignmentTypeService;
        });
        
        $this->app->singleton("ministries", function() {
            return new MinistryService;
        });
        
        $this->app->singleton("organizations", function() {
            return new OrganizationService;
        });
        
        $this->app->singleton("organization-types", function() {
            return new OrganizationTypeService;
        });
        
        $this->app->singleton("organization-departments", function() {
            return new OrganizationDepartmentService;
        });

        $this->app->singleton("organization-locations", function() {
            return new OrganizationLocationService;
        });

        $this->app->singleton("notifications", function() {
            return new NotificationService;
        });

        $this->app->singleton("messages", function() {
            return new MessageService;
        });

        $this->app->singleton("task-progress-reports", function() {
            return new TaskProgressReportService;
        });

        $this->app->singleton("task-progress-report-reviews", function() {
            return new TaskProgressReportReviewService;
        });

        $this->app->singleton("task-progress-report-attachments", function() {
            return new TaskProgressReportAttachmentService;
        });

        //
        // Utilities
        //

        $this->app->singleton("dates", function() {
            return new DateService;
        });

        $this->app->singleton("uploader", function() {
            return new UploadService;
        });

        $this->app->singleton("reputation", function() {
            return new ReputationService;
        });
    }

    private function defineGates()
    {
        Gate::define("access-admin-panel", function($user) {
            return $user->is_admin;
        });
    }

    private function registerPolicies()
    {
        foreach ($this->policies as $key => $value)
        {
            Gate::policy($key, $value);
        }
    }

    private function composeViews()
    {
        // dd(app()->getLocale());

        View::composer("tessify-core::layouts.app", function($view) {
            $view->with("user", Auth::user());
            $view->with("locales", config("tessify-core.locales"));
            $view->with("activeLocale", app()->getLocale());
            $view->with("numUnreadNotifications", app("notifications")->numUnread());
            $view->with("numUnreadMessages", app("messages")->numUnread());
        });

        View::composer("tessify-core::layouts.admin", function($view) {
            $view->with("user", Auth::user());
        });
    }
}
