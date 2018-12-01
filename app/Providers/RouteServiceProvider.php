<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $spotifyNamespace = 'App\Http\Controllers\Spotify';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapPublicApiRoutes();
        $this->mapPrivateApiRoutes();
        $this->mapSpotifyRoutes();
        $this->mapWebRoutes();
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
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapPublicApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/publicApi.php'));
    }

    protected function mapPrivateApiRoutes()
    {
        Route::prefix('api')
            ->middleware('auth:api')
            ->namespace($this->namespace)
            ->group(base_path('routes/privateApi.php'));
    }

    protected function mapSpotifyRoutes()
    {
        Route::prefix('spotify')
            ->middleware('web')
            ->namespace($this->spotifyNamespace)
            ->group(base_path('routes/spotify.php'));
    }
}
