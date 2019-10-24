<?php

namespace App\Components\Spotify\Api;

use App\Exceptions\FailedSpotifyTokenRefreshException;
use App\Exceptions\NoUserTokenProvidedException;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\SpotifyWebAPIException;

class UserBoundSpotifyApi extends SpotifyWebAPI
{
    /** @var User */
    private $user;
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
    }

    /**
     * @param User|null $user
     * @return $this
     * @throws FailedSpotifyTokenRefreshException
     */
    public function setApiUser(User $user = null)
    {
        if (!$user) {
            return $this;
        }

        $this->user = $user;
        if ($user->spotify_id) {
            $this->setAccessToken($user->spotify_access_token);
            $this->refreshUserTokenIfNeeded();
        }

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

    /** @throws FailedSpotifyTokenRefreshException */
    public function refreshUserTokenIfNeeded()
    {
        if (!$this->user || !$this->user->spotify_id || $this->user->spotify_token_expire > Carbon::now()) {
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

    public function getAccessToken()
    {
        return $this->accessToken;
    }
}
