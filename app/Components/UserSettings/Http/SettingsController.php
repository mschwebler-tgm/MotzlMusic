<?php

namespace App\Components\UserSettings\Http;

use App\Components\UserSettings\Http\Requests\UserNameChangeRequest;
use App\Components\UserSettings\Http\Requests\UserSettingsNotificationsRequest;
use App\Components\UserSettings\Http\Requests\UserSettingsPrivacyRequest;
use App\Components\UserSettings\SettingsDao;
use App\Daos\UserDao;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    private $settingsDao;

    public function __construct(SettingsDao $settingsDao)
    {
        $this->settingsDao = $settingsDao;
    }

    public function storeNotificationSettings(UserSettingsNotificationsRequest $request)
    {
        return $this->settingsDao->updateNotificationSettingsForUser(apiUser(), $request->getNotificationSettings());
    }

    public function storePrivacySettings(UserSettingsPrivacyRequest $request)
    {
        return $this->settingsDao->updatePrivacySettingsForUser(apiUser(), $request->getPrivacySettings());
    }

    public function storeUserNickname(UserNameChangeRequest $request, UserDao $userDao)
    {
        return $userDao->updateName(apiUser(), $request->getName());
    }
}
