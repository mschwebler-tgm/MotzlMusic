<?php

namespace App\Http\Requests;

use Illuminate\Database\Eloquent\Builder;

class Sort
{
    private $identifier;
    private $direction;

    const FIELD_BY_IDENTIFIER = [
        'name' => 'name',
        'duration' => 'duration',
        'album' => 'album_name',
        'artist' => 'artist_name',
        'rating' => 'user_rating',
    ];

    public function __construct($identifier, $direction)
    {
        $this->identifier = $identifier;
        $this->direction = $direction;
    }

    public function apply(Builder $query)
    {
        $query->orderBy(self::FIELD_BY_IDENTIFIER[$this->identifier], $this->direction);
    }
}
