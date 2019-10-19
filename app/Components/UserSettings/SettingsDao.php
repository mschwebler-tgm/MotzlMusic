<?php

namespace App\Components\UserSettings;

use App\User;

class SettingsDao
{

    public function updateNotificationSettingsForUser(User $user, UserSettingsNotifications $notificationSettings)
    {
        $user->settings = new UserSettings(
            $notificationSettings,
            $user->settings->getPrivacySettings(),
            $user->settings->getAppearanceSettings()
        );
        $user->save();

        return $user->settings;
    }

    public function updatePrivacySettingsForUser(User $user, UserSettingsPrivacy $privacySettings)
    {
        $user->settings = new UserSettings(
            $user->settings->getNotificationSettings(),
            $privacySettings,
            $user->settings->getAppearanceSettings()
        );
        $user->save();

        return $user->settings;
    }

    public function updateAppearanceSettings(User $user, UserSettingsAppearance $getAppearanceSettings)
    {
        $user->settings = new UserSettings(
            $user->settings->getNotificationSettings(),
            $user->settings->getPrivacySettings(),
            $getAppearanceSettings
        );
        $user->save();

        return $user->settings;
    }
}
