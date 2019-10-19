<?php

namespace App\Components\UserSettings;

use Illuminate\Support\Str;

class UserSettingsAppearance
{
    private $theme;

    public function __construct($theme)
    {
        $this->theme = $theme;
    }

    public static function fromArray(array $appearanceSettings)
    {
        return new self(
            $appearanceSettings['theme']
        );
    }

    public function toArray()
    {
        $settings = [];
        foreach (get_object_vars($this) as $key => $setting) {
            $settings[Str::snake($key)] = $setting;
        }

        return $settings;
    }
}
