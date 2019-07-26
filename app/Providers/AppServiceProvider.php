<?php

namespace App\Providers;

use App\Observers\TrackObserver;
use App\Track;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (\App::environment() === 'production') {
            $this->app['request']->server->set('HTTPS', true);
        }

        $this->registerModelObserver();
    }

    private function registerModelObserver()
    {
        Track::observe(TrackObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
