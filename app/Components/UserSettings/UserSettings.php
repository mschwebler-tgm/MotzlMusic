<?php

namespace App\Components\UserSettings;

class UserSettings
{
    public static function defaultSettingsJSON()
    {
        return json_encode(config('user-settings.default-settings'));
    }
}
