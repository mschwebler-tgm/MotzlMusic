<?php

namespace App\Components\UserSettings\Http\Requests;

use App\Components\UserSettings\UserSettingsPrivacy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserSettingsPrivacyRequest extends FormRequest
{
    public function authorize()
    {
        return (bool)apiUser();
    }

    public function rules()
    {
        return [
            'incognito' => 'required|boolean',
            'like_activity' => 'required|boolean',
            'online_status' => 'required|boolean',
            'post_uploads' => 'required|boolean',
            'show_name_on_posts' => 'required|boolean',
            'profile_visibility' => Rule::in(UserSettingsPrivacy::PROFILE_VISIBILITY_OPTIONS),
        ];
    }

    public function getPrivacySettings()
    {
        return UserSettingsPrivacy::fromArray($this->all());
    }
}
