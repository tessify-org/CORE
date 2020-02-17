<?php

namespace Tessify\Core\Providers;

use Tessify\Core\Services\CoreService;
use Tessify\Core\Services\Utilities\DateService;
use Tessify\Core\Services\Utilities\UploadService;
use Tessify\Core\Services\ModelServices\UserService;
use Tessify\Core\Services\ModelServices\TaskService;
use Tessify\Core\Services\ModelServices\SkillService;
use Tessify\Core\Services\ModelServices\ProjectService;
use Tessify\Core\Services\ModelServices\CommentService;
use Tessify\Core\Services\ModelServices\TeamRoleService;
use Tessify\Core\Services\ModelServices\TaskStatusService;
use Tessify\Core\Services\ModelServices\TeamMemberService;
use Tessify\Core\Services\ModelServices\WorkMethodService;
use Tessify\Core\Services\ModelServices\ProjectStatusService;
use Tessify\Core\Services\ModelServices\ProjectCategoryService;
use Tessify\Core\Services\ModelServices\ProjectResourceService;
use Tessify\Core\Services\ModelServices\TeamMemberApplicationService;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    // Define policies
    protected $policies = [
        'Tessify\Core\Models\Job' => 'Tessify\Core\Policies\JobPolicy',
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
        $this->publishes([__DIR__."/../../config/config.php" => config_path("tessify-core.php")], "config");
        
        // Define the authorization Gates
        $this->defineGates();

        // Config publishing
        $this->publishes([
            __DIR__."/../../config/config.php" => config_path("tessify-core.php"),
            __DIR__."/../../config/breadcrumbs.php" => config_path("breadcrumbs.php"),
        ], "config");
        
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
        //
        // Register the Core Service
        //

        $this->app->singleton("core", function() {
            return new CoreService;
        });

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

        //
        // Utilities
        //

        $this->app->singleton("dates", function() {
            return new DateService;
        });

        $this->app->singleton("uploader", function() {
            return new UploadService;
        });
    }

    private function defineGates()
    {
        Gate::define("access-admin-panel", function($user) {
            return $user->is_admin;
        });
    }
}