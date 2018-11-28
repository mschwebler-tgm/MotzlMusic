<?php

namespace App\Service\Spotify;

use App\Exceptions\FailedSpotifyTokenRefreshException;
use App\Exceptions\NoUserTokenProvidedException;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPIException;

class SpotifyApiService extends SpotifyWebAPI
{
    /** @var User */
    private $user;
    private $session;

    public function __construct($request = null)
    {
        parent::__construct($request);
        $this->session = new Session(
            env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET'),
            config('spotify.auth_redirect')
        );
        $this->session->requestCredentialsToken();
        // only needed for application requests
//        $accessToken = $this->session->getAccessToken();
//        $this->setAccessToken($accessToken);
    }

    public function setApiUser(User $user)
    {
        $this->user = $user;
        $this->setAccessToken($user->spotify_access_token);
        return $this;
    }

    public function getApiUser()
    {
        return $this->user;
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
            // use setApiUser() before, to get access to user specific data
            throw new NoUserTokenProvidedException();
        }
    }

    /** @throws NoUserTokenProvidedException */
    public function forceSpotifyUser()
    {
        if (!$this->user) {
            throw new NoUserTokenProvidedException();
        }
    }

    public function getAllMyPlaylists()
    {
        return $this->getAllUserPlaylists($this->user->spotify_id);
    }

    public function getAllUserPlaylists($spotifyUserId)
    {
        $itemsPerPage = 20;
        $offset = 0;
        $playlists = [];
        do {
            $response = $this->getUserPlaylists($spotifyUserId, ['limit' => $itemsPerPage, 'offset' => $offset]);
            $playlists = array_merge($response->items, $playlists);
            $offset += $itemsPerPage;
        } while (count($playlists) < $response->total);
        return $playlists;
    }

    /** @throws FailedSpotifyTokenRefreshException */
    public function refreshUserTokenIfNeeded()
    {
        if (!$this->user || $this->user->spotify_token_expire > Carbon::now()->subHour()) {
            return;
        }

        $success = $this->session->refreshAccessToken($this->user->spotify_refresh_token);
        if (!$success) {
            Log::error("Failed to regenerate access token for user {$this->user->name} (ID: {$this->user->id}) with refresh token");
            throw new FailedSpotifyTokenRefreshException();
        }
        $newAccessToken = $this->session->getAccessToken();
        $this->setAccessToken($newAccessToken);
        $this->user->update([
            'spotify_access_token' => $newAccessToken,
            'spotify_token_expire' => Carbon::now()->addHour()->toDateTimeString()
        ]);
    }
}
