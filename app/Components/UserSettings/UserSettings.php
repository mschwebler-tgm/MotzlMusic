<?php

namespace App\Components\UserSettings;

use JsonSerializable;

class UserSettings implements JsonSerializable
{
    private $notificationSettings;
    private $privacySettings;
    private $appearanceSettings;

    public function __construct(
        UserSettingsNotifications $notificationSettings,
        UserSettingsPrivacy $privacySettings,
        UserSettingsAppearance $appearanceSettings
    )
    {
        $this->notificationSettings = $notificationSettings;
        $this->privacySettings = $privacySettings;
        $this->appearanceSettings = $appearanceSettings;
    }

    public static function fromJson($settings)
    {
        $settings = json_decode($settings, true);
        return new self(
            UserSettingsNotifications::fromArray(self::getSettings($settings, 'notifications')),
            UserSettingsPrivacy::fromArray(self::getSettings($settings, 'privacy')),
            UserSettingsAppearance::fromArray(self::getSettings($settings, 'appearance'))
        );
    }

    private static function getSettings(array $settings, string $key)
    {
        return $settings[$key] ?? config("user-settings.default-settings.$key");
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
            'appearance' => $this->appearanceSettings->toArray(),
        ];
    }

    public static function defaultSettingsJSON()
    {
        return json_encode(config('user-settings.default-settings'));
    }

    /**
     * @return UserSettingsNotifications
     */
    public function getNotificationSettings(): UserSettingsNotifications
    {
        return $this->notificationSettings;
    }

    /**
     * @return UserSettingsPrivacy
     */
    public function getPrivacySettings(): UserSettingsPrivacy
    {
        return $this->privacySettings;
    }

    /**
     * @return UserSettingsPrivacy
     */
    public function getAppearanceSettings(): UserSettingsAppearance
    {
        return $this->appearanceSettings;
    }
}
