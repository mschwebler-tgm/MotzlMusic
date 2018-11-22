<?php

namespace App\Providers;

use App\Service\Spotify\SpotifyApiService;
use App\User;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;

class SpotifyApiProvider extends ServiceProvider
{
    /**
     * @param Encrypter $encrypter
     * @param SpotifyApiService $spotifyApiService
     * @throws \App\Exceptions\FailedSpotifyTokenRefreshException
     */
    public function boot(Encrypter $encrypter, SpotifyApiService $spotifyApiService)
    {
        $userToken = Cookie::get('remember');
        if ($userToken) {
            $encryptedToken = $encrypter->decrypt($userToken);
            list($password, $email) = explode(':', $encryptedToken);
            $user = User::where('email', $email)->first();
            $spotifyApiService->setUser($user);
            $spotifyApiService->refreshUserTokenIfNeeded();
        }
    }

    public function register()
    {
        $this->app->singleton(SpotifyApiService::class, function ($app) {
            return new SpotifyApiService();
        });
    }
}
