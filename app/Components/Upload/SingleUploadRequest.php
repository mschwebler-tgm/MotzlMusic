<?php

namespace App\Components\Upload;

use Illuminate\Foundation\Http\FormRequest;

class SingleUploadRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'track' => [
                'required',
                'mimetypes:audio/mpeg'
            ]
        ];
    }

    public function getFile()
    {
        return $this->file('track');
    }

    public function getFileName()
    {
        return pathinfo($this->getFile()->getClientOriginalName(), PATHINFO_FILENAME);
    }
}
