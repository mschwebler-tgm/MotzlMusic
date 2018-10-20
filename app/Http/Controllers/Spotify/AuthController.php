<?php

namespace App\Http\Controllers\Spotify;

use App\Daos\UserDao;
use App\Http\Controllers\Controller;
use App\Service\Spotify\SpotifyAuthService;
use Illuminate\Support\Facades\Input;

class AuthController extends Controller
{
    private $authService;

    public function __construct(SpotifyAuthService $authService)
    {

        $this->authService = $authService;
    }

    public function requestAuthCode()
    {
        return redirect($this->authService->generateAuthUrl());
    }

    public function authorizeUser(UserDao $userDao)
    {
        if (Input::has('code')) {
            $authResponse = $this->authService->requestAccessToken(Input::get('code'));
            $userData = $this->authService->requestUserData($authResponse->access_token);
            $userToken = $userDao->createFromSpotifyAuthorization($authResponse, $userData);
            return redirect('/')->withCookie(cookie('remember', $userToken, 525600));  // remember for 1 year
        } else {
            return abort(403);
        }
    }
}
