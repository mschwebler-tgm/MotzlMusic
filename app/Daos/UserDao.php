<?php

namespace App\Daos;

use App\User;
use Carbon\Carbon;

class UserDao
{
    public function createFromSpotifyAuthorization($authResponse, $userData)
    {
        /** @var User $user */
        $user = User::firstOrCreate([
            'spotify_id' => $userData->id
        ]);
        $password = str_random(20);
        $localToken = encrypt($password . ':' . $userData->email);
        $user->fill([
            'name' => $userData->display_name,
            'email' => $userData->email,
            'spotify_id' => $userData->id,
            'spotify_access_token' => $authResponse->access_token,
            'spotify_refresh_token' => $authResponse->refresh_token,
            'birthdate' => $userData->birthdate,
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt($password)
        ]);
        $user->save();
        return $localToken;
    }
}