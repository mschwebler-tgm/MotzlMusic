<?php

namespace App\Service\Spotify;

use Illuminate\Support\Facades\Log;

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
        $redirectUrl = config('spotify.auth_redirect');
        $clientId = env('SPOTIFY_CLIENT_ID');
        $responseType = 'code';
        $scopes = implode(' ', config('spotify.scopes'));
        $url = config('spotify.auth_path') .
            "?client_id=$clientId&response_type=$responseType&scope=$scopes&redirect_uri=$redirectUrl";
        return $url;
    }

    public function requestAccessToken($code)
    {
        $response = $this->makeAuthRequest($code);
        if ($response) {
            return $response;
        } else {
            return abort(403);
        }
    }

    private function makeAuthRequest($code)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config('spotify.token_url'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => url(config('spotify.auth_redirect')),
            'client_id' => env('SPOTIFY_CLIENT_ID'),
            'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $serverOutput = curl_exec($ch);
        curl_close($ch);
        return json_decode($serverOutput);
    }

    public function requestUserData($accessToken)
    {
        $response = $this->makeUserRequest($accessToken);
        if ($response) {
            return $response;
        } else {
            return abort(403);
        }
    }

    private function makeUserRequest($accessToken)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/me");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $headers = [];
        $headers[] = "Accept: application/json";
        $headers[] = "Content-Type: application/json";
        $headers[] = "Authorization: Bearer $accessToken";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $serverOutput = curl_exec($ch);
        if (curl_errno($ch)) {
            Log::critical('Error:' . curl_error($ch));
        }
        curl_close ($ch);
        return json_decode($serverOutput);
    }
}