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
            return $userDao->createFromSpotifyAuthorization($authResponse, $userData);
        } else {
            return abort(403);
        }
    }
}