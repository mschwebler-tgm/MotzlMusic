<?php

namespace App\Http\Controllers\Spotify;

use App\Components\Spotify\Api\UserBoundSpotifyApi;
use App\Daos\UserDao;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class AuthController extends Controller
{
    public function requestAuthCode()
    {
        /** @var RedirectResponse $redirectResponse */
        $redirectResponse = Socialite::driver('spotify')->scopes(config('spotify.scopes'))->redirect();
        parse_str(parse_url($redirectResponse->getTargetUrl(), PHP_URL_QUERY), $getParams);
//        \Log::info($getParams['state']);
//        dd(Auth::user(), $getParams);
        return $redirectResponse;
    }

    public function authorizeUser(UserDao $userDao)
    {
        try {
            /** @var \SocialiteProviders\Manager\OAuth2\User $oauth2User */
            $oauth2User = Socialite::driver('spotify')->user();
        } catch (InvalidStateException $e) {
            return redirect('/spotify/authorize');
        }
//        dd($oauth2User, Auth::user());
        $user = $userDao->createFromSpotifyAuthorization($oauth2User);
        Auth::login($user, true);
        return redirect('/');
    }

    public function getAccessToken(UserBoundSpotifyApi $spotifyApi)
    {
        return $spotifyApi->getAccessToken();
    }
}
