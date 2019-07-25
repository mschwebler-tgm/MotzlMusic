<?php

namespace App\Components\UserSettings;

use App\User;

class SettingsDao
{

    public function updateNotificationSettingsForUser(User $user, UserSettingsNotifications $notificationSettings)
    {
        /** @var UserSettings $settings */
        $settings = $user->settings;
        $settings->setNotificationSettings($notificationSettings);
        $user->settings = $settings;
        $user->save();
    }
}
