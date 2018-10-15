<?php

namespace App\Service\Spotify;

/**
 * Class SpotifyAuthService
 * https://developer.spotify.com/documentation/general/guides/authorization-guide/#authorization-code-flow
 *
 * @package App\Service\Spotify
 */
class SpotifyAuthService
{

    /**
     * 1. Have your application request authorization; the user logs in and authorizes access
     * @return string
     */
    public function generateAuthUrl()
    {
        $redirectUrl = request()->getUriForPath('/');
        $clientId = env('SPOTIFY_CLIENT_ID');
        $responseType = 'code';
        $scopes = implode(' ', config('spotify.scopes'));
        $url = config('spotify.auth_path') .
            "?client_id=$clientId&response_type=$responseType&scope=$scopes&redirect_uri=$redirectUrl";
        return $url;
    }
}