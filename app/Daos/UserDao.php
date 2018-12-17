<?php

namespace App\Daos;

use App\User;

class UserDao
{
    public function createFromSpotifyAuthorization(\SocialiteProviders\Manager\OAuth2\User $oauth2User)
    {
        /** @var User $user */
        $user = User::firstOrCreate([
            'name' => $oauth2User->name,
            'email' => $oauth2User->email,
            'spotify_id' => $oauth2User->id
        ]);
        $user->fill([
            'name' => $oauth2User->name,
            'email' => $oauth2User->email,
            'spotify_id' => $oauth2User->id,
            'spotify_access_token' => $oauth2User->token,
            'spotify_refresh_token' => $oauth2User->refreshToken,
            'birthdate' => $oauth2User->user['birthdate'],
            'password' => bcrypt(str_random(20))
        ]);
        $user->save();
        return $user;
    }

    public function setSpotifyImportComplete()
    {
        $user = apiUser();
        $user->spotify_import_complete = true;
        $user->save();
    }
}
