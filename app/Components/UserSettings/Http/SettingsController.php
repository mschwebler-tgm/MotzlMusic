<?php

namespace App\Components\UserSettings\Http;

use App\Components\UserSettings\Http\Requests\UserSettingsNotificationsRequest;
use App\Components\UserSettings\Http\Requests\UserSettingsPrivacyRequest;
use App\Components\UserSettings\SettingsDao;
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
}
