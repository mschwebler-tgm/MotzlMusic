<?php

namespace App\Http\Controllers\Spotify;

use App\Daos\UserDao;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function requestAuthCode()
    {
        return Socialite::driver('spotify')->scopes(config('spotify.scopes'))->redirect();
    }

    public function authorizeUser(UserDao $userDao)
    {
        /** @var \SocialiteProviders\Manager\OAuth2\User $oauth2User */
        $oauth2User = Socialite::driver('spotify')->user();
        $user = $userDao->createFromSpotifyAuthorization($oauth2User);
        Auth::login($user, true);
        return redirect('/');
    }
}
