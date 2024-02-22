<?php

namespace Modules\Setting\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\Setting\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapDashboardRoutes();
        $this->mapClientRoutes();
        $this->mapAdviserRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Setting', '/Routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Setting', '/Routes/api.php'));
    }

    protected function mapDashboardRoutes()
    {
        Route::prefix('dashboard')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Setting', '/Routes/dashboard.php'));
    }
    protected function mapClientRoutes()
    {
        Route::prefix('client')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Setting', '/Routes/client.php'));
    }
    protected function mapAdviserRoutes()
    {
        Route::prefix('adviser')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Setting', '/Routes/adviser.php'));
    }
}
