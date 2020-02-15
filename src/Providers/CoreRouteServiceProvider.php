<?php

namespace Tessify\Core\Providers;

use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;

class CoreRouteServiceProvider extends RouteServiceProvider
{
    protected $namespace = "Tessify\Core\Http\Controllers";

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapWebRoutes();
    }

    public function mapWebRoutes()
    {
        Route::middleware("web")
             ->namespace($this->namespace)
             ->group(__DIR__."/../Routes/web.php");
    }
}