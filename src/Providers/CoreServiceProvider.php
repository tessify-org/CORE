<?php

namespace Tessify\Core\Providers;

use Tessify\Core\Services\CoreService;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
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
    }

    public function register()
    {
        // Register the CoreService to the IoC container
        $this->app->singleton("core", function() {
            return new CoreService;
        });
    }
}