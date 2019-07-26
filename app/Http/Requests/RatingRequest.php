<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends FormRequest
{
    public function rules()
    {
        return [
            'rating' => 'required|numeric|min:0|max:5',
        ];
    }

    public function getRating()
    {
        return $this->get('rating');
    }
}
