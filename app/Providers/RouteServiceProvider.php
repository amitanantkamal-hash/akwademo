<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')->prefix('api')->group(base_path('routes/api.php'));

            Route::middleware('web')->group(base_path('routes/web.php'));
        });
    }

    protected function mapCTWAMetaRoutes()
    {
        Route::middleware('web')->namespace('App\Modules\CTWAMeta\Controllers')->group(base_path('app/Modules/CTWAMeta/Routes/web.php'));
    }

    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        // Add this line to register your module routes
        $this->mapCTWAMetaRoutes();

        // If you have other route groups, they would go here
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
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
            ->group(base_path('routes/api.php'));
    }

}
