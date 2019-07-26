<?php

namespace App\Components\UserSettings\Http\Requests;

use App\Components\UserSettings\UserSettingsPrivacy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserNameChangeRequest extends FormRequest
{
    public function authorize()
    {
        return (bool)apiUser();
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:4|max:16',
        ];
    }

    public function getName()
    {
        return $this->get('name');
    }
}
