<?php

namespace App\Http\Controllers\Auth\Socialite;

use App\Daos\UserDao;
use Laravel\Socialite\Facades\Socialite;

class SpotifyAuthController
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::with('spotify')->scopes(config('spotify.scopes'))->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(UserDao $userDao)
    {
        /** @var \SocialiteProviders\Manager\OAuth2\User $user */
        $user = Socialite::with('spotify')->user();
        $userToken = $userDao->createFromSpotifyAuthorization($user);
        return redirect('/')->withCookie(cookie('remember', $userToken, 525600));  // remember for 1 year
    }
}
