<?php

namespace App\Components\UserSettings;

use JsonSerializable;

class UserSettings implements JsonSerializable
{
    private $notificationSettings;
    private $privacySettings;

    public function __construct(UserSettingsNotifications $notificationSettings, UserSettingsPrivacy $privacySettings)
    {
        $this->notificationSettings = $notificationSettings;
        $this->privacySettings = $privacySettings;
    }

    public static function fromJson($settings)
    {
        $settings = json_decode($settings, true);
        return new self(
            UserSettingsNotifications::fromArray($settings['notifications']),
            UserSettingsPrivacy::fromArray($settings['privacy'])
        );
    }

    public function toJson()
    {
        return json_encode($this->jsonSerialize());
    }

    public function jsonSerialize()
    {
        return [
            'privacy' => $this->privacySettings->toArray(),
            'notifications' => $this->notificationSettings->toArray(),
        ];
    }

    public static function defaultSettingsJSON()
    {
        return json_encode(config('user-settings.default-settings'));
    }

    public function setNotificationSettings(UserSettingsNotifications $notificationSettings)
    {
        $this->notificationSettings = $notificationSettings;
    }
}
