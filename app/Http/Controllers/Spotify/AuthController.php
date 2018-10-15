<?php

namespace App\Http\Controllers\Spotify;

use App\Http\Controllers\Controller;
use App\Service\Spotify\SpotifyAuthService;

class AuthController extends Controller
{
    private $authService;

    public function __construct(SpotifyAuthService $authService)
    {

        $this->authService = $authService;
    }

    public function authorizeSpotify()
    {
        return redirect($this->authService->generateAuthUrl());
    }
}