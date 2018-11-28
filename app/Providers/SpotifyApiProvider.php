<?php

namespace App\Providers;

use App\Service\Spotify\SpotifyApiService;
use Illuminate\Support\ServiceProvider;

class SpotifyApiProvider extends ServiceProvider
{
    /**
     * @param SpotifyApiService $spotifyApiService
     * @throws \App\Exceptions\FailedSpotifyTokenRefreshException
     */
    public function boot(SpotifyApiService $spotifyApiService)
    {
        $spotifyApiService->setApiUser(apiUser());
        $spotifyApiService->refreshUserTokenIfNeeded();
    }

    public function register()
    {
        $this->app->singleton(SpotifyApiService::class, function ($app) {
            return new SpotifyApiService();
        });
    }
}
