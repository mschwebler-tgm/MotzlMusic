<?php

namespace App\Components\UserSettings;

use App\User;

class SettingsDao
{

    public function updateNotificationSettingsForUser(User $user, UserSettingsNotifications $notificationSettings)
    {
        $user->settings = new UserSettings(
            $notificationSettings,
            $user->settings->getPrivacySettings()
        );
        $user->save();
    }

    public function updatePrivacySettingsForUser(User $user, UserSettingsPrivacy $privacySettings)
    {
        $user->settings = new UserSettings(
            $user->settings->getNotificationSettings(),
            $privacySettings
        );
        $user->save();
    }
}
