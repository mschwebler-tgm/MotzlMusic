<?php

namespace App\Service\Spotify;

use App\Exceptions\NoUserTokenProvidedException;
use App\User;
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPIException;

class SpotifyApiService extends SpotifyWebAPI
{
    public function __construct($request = null)
    {
        parent::__construct($request);
        $session = new Session(
            env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET'),
            config('spotify.auth_redirect')
        );
        $session->requestCredentialsToken();
        $accessToken = $session->getAccessToken();
        $this->setAccessToken($accessToken);
    }

    public function setUser(User $user)
    {
        $this->setAccessToken($user->spotify_access_token);
    }

    /**
     * @return array|object
     * @throws NoUserTokenProvidedException
     */
    public function me()
    {
        try {
            return parent::me();
        } catch (SpotifyWebAPIException $e) {
            // MotzlMusic application token was used to submit the request.
            // use setUser() before, to get access to user specific data
            throw new NoUserTokenProvidedException();
        }
    }
}
