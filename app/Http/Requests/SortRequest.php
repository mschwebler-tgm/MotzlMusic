<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SortRequest extends FormRequest
{
    public function rules()
    {
        return [
            'ids' => 'required|array',
            'sorting' => 'array'
        ];
    }

    public function getTrackIds()
    {
        return $this->get('ids');
    }

    public function getSorting()
    {
        $sorting = collect($this->get('sorting', []));

        return $sorting->map(function ($sort) {
            return new Sort($sort['identifier'], $sort['direction']);
        });
    }
}
