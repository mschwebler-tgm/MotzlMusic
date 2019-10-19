<?php

namespace App\Components\UserSettings;

use Illuminate\Support\Str;

class UserSettingsAppearance
{
    private $theme;
    private $brightness;

    public function __construct($theme, $brightness)
    {
        $this->theme = $theme;
        $this->brightness = $brightness;
    }

    public static function fromArray(array $appearanceSettings)
    {
        return new self(
            $appearanceSettings['theme'],
            $appearanceSettings['brightness']
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
