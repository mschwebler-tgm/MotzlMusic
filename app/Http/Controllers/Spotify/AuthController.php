<?php

namespace App\Http\Controllers\Spotify;

use App\Daos\UserDao;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class AuthController extends Controller
{
    public function requestAuthCode()
    {
        return Socialite::driver('spotify')->scopes(config('spotify.scopes'))->redirect();
    }

    public function authorizeUser(UserDao $userDao)
    {
        try {
            /** @var \SocialiteProviders\Manager\OAuth2\User $oauth2User */
            $oauth2User = Socialite::driver('spotify')->user();
        } catch (InvalidStateException $e) {
            return redirect('/spotify/authorize');
        }
        $user = $userDao->createFromSpotifyAuthorization($oauth2User);
        Auth::login($user, true);
        return redirect('/');
    }

    public function getAccessToken(UserDao $userDao)
    {
        return $userDao->getCurrentUsersAccessToken();
    }
}
