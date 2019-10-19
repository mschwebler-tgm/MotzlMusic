<?php

namespace App\Components\UserSettings\Http\Requests;

use App\Components\UserSettings\UserSettingsAppearance;
use Illuminate\Foundation\Http\FormRequest;

class UserSettingsAppearanceRequest extends FormRequest
{
    public function authorize()
    {
        return (bool)apiUser();
    }

    public function rules()
    {
        return [
            'theme' => 'required|string',
        ];
    }

    public function getAppearanceSettings()
    {
        return UserSettingsAppearance::fromArray($this->all());
    }
}
