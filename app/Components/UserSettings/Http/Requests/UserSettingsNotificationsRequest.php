<?php

namespace App\Components\UserSettings\Http\Requests;

use App\Components\UserSettings\UserSettingsNotifications;
use Illuminate\Foundation\Http\FormRequest;

class UserSettingsNotificationsRequest extends FormRequest
{
    public function authorize()
    {
        return (bool)apiUser();
    }

    public function rules()
    {
        return [
            'uploads' => 'required|boolean',
            'messages' => 'required|boolean',
            'concerts' => 'required|boolean',
        ];
    }

    public function getNotificationSettings()
    {
        return UserSettingsNotifications::fromArray($this->all());
    }
}
