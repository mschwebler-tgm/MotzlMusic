<?php

namespace App\Components\Profile;

class ProfileImageService
{
    const BASE_URL = 'https://www.gravatar.com/avatar/';

    static function fromEmail($email)
    {
        $hash = self::getGravatarHash($email);

        return self::BASE_URL . $hash . '?d=robohash';
    }

    private static function getGravatarHash($email)
    {
        return md5($email);
    }
}
