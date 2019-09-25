<?php

namespace App\Providers;

use App\Components\Spotify\Api\UserBoundSpotifyApi;
use Illuminate\Support\ServiceProvider;

class UserBoundSpotifyApiProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UserBoundSpotifyApi::class, function ($app) {
            $spotifyApi = new UserBoundSpotifyApi();
            $spotifyApi->setApiUser(apiUser());
            $spotifyApi->refreshUserTokenIfNeeded();
            return $spotifyApi;
        });
    }
}
