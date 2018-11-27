<?php

namespace App\Daos;

use App\User;
use SocialiteProviders\Manager\OAuth2\User as OAuthUser;

class UserDao
{
    public function createFromSpotifyAuthorization(OAuthUser $spotifyUser)
    {
        /** @var User $user */
        $user = User::firstOrCreate([
            'spotify_id' => $spotifyUser->id,
            'name' => $spotifyUser->name,
            'email' => $spotifyUser->email
        ]);
        $password = str_random(20);
        $localToken = encrypt($password . ':' . $spotifyUser->email);
        $user->fill([
            'spotify_id' => $spotifyUser->id,
            'spotify_access_token' => $spotifyUser->token,
            'spotify_refresh_token' => $spotifyUser->refreshToken,
            'birthdate' => $spotifyUser->user['birthdate'],
            'password' => bcrypt($password)
        ]);
        $user->save();
        return $localToken;
    }
}
