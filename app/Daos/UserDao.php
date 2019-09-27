<?php

namespace App\Daos;

use App\Components\Profile\ProfileImageService;
use App\User;

class UserDao
{
    public function createFromSpotifyAuthorization(\SocialiteProviders\Manager\OAuth2\User $oauth2User)
    {
        $columns = [
            'name' => $oauth2User->name,
            'email' => $oauth2User->email,
        ];
        $user = User::where($columns)->first();

        if (!$user) {
            $user = $this->createUser($columns);
        }

        $user->fill([
            'name' => $oauth2User->name,
            'email' => $oauth2User->email,
            'spotify_id' => $oauth2User->id,
            'spotify_access_token' => $oauth2User->token,
            'spotify_refresh_token' => $oauth2User->refreshToken,
            'birthdate' => $oauth2User->user['birthdate'],
        ]);
        $user->save();
        return $user;
    }

    /**
     * @param array $options column => value
     * @return User
     */
    public function createUser(array $options)
    {
        $options['profile_image'] = $options['profile_image'] ?? ProfileImageService::fromEmail($options['email']);

        return User::create($options);
    }

    public function setSpotifyImportComplete()
    {
        $user = apiUser();
        $user->spotify_import_complete = true;
        $user->save();
    }

    public function updateName(User $user, $name)
    {
        $user->name = $name;
        $user->save();

        return $user->name;
    }

    public function updateSubContent(array $subContent)
    {
        $user = apiUser();
        $user->sub_content = $subContent;
        $user->save();
    }
}
