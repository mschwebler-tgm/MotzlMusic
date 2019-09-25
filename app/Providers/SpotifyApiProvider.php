<?php

namespace App\Providers;

use App\Components\Spotify\Api\SpotifyApi;
use Illuminate\Support\ServiceProvider;

class SpotifyApiProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SpotifyApi::class, function ($app) {
            $spotifyApi = new SpotifyApi();
            $spotifyApi->setApiUser(apiUser());
            return $spotifyApi;
        });
    }
}
