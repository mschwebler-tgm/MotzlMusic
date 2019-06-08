<?php

namespace App\Components\Player\Spotify\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpotifyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (bool)apiUser()->spotify_id;
    }

    public function rules()
    {
        return [
            'device_id' => 'required',
        ];
    }

    public function getDeviceId()
    {
        return $this->get('device_id');
    }
}
