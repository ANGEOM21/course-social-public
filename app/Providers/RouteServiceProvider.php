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
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $webFiles = [];
        foreach (glob(__DIR__ . '/../../routes/*.php') as $file) {
            $name = basename($file);
            if (in_array($name, ['api.php', 'console.php'])) {
                continue;
            }
            $webFiles[] = $file;
        }

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () use ($webFiles) {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            foreach ($webFiles as $file) {
                Route::middleware('web')
                    ->group($file);
            }
        });
    }
}
