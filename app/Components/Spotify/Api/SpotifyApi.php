<?php

namespace App\Components\Spotify\Api;

use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyApi extends SpotifyWebAPI
{
    protected $session;

    public function __construct($request = null)
    {
        parent::__construct($request);
        $this->session = new Session(
            env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET'),
            config('spotify.auth_redirect')
        );
        $this->session->requestCredentialsToken();
        $this->setAccessToken($this->session->getAccessToken());
    }
}
