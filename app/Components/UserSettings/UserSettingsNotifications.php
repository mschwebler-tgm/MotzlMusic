<?php

namespace App\Components\UserSettings;

class UserSettingsNotifications
{
    private $uploads;
    private $messages;
    private $concerts;

    public function __construct($uploads, $messages, $concerts)
    {
        $this->uploads = $uploads;
        $this->messages = $messages;
        $this->concerts = $concerts;
    }

    public static function fromArray(array $notificationSettings)
    {
        return new self(
            $notificationSettings['uploads'],
            $notificationSettings['messages'],
            $notificationSettings['concerts']
        );
    }

    public function toArray()
    {
        $settings = [];
        foreach (get_object_vars($this) as $key => $setting) {
            $settings[snake_case($key)] = $setting;
        }

        return $settings;
    }
}
