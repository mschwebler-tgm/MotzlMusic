<?php

namespace App\Providers;

use App\Exceptions\FailedSpotifyTokenRefreshException;
use App\Service\Spotify\SpotifyApiService;
use Illuminate\Support\ServiceProvider;

class SpotifyApiProvider extends ServiceProvider
{
    /**
     * @param SpotifyApiService $spotifyApiService
     * @throws FailedSpotifyTokenRefreshException
     */
    public function boot(SpotifyApiService $spotifyApiService)
    {
        $spotifyApiService->setApiUser(apiUser());
    }

    public function register()
    {
        $this->app->singleton(SpotifyApiService::class, function ($app) {
            return new SpotifyApiService();
        });
    }
}
