<?php

namespace App\Components\Spotify\Models;

class Artist extends BaseModel
{
    /** @var string */
    public $id;
    /** @var object */
    public $followers;
    /** @var array */
    public $genres;
    /** @var string */
    public $href;
    /** @var array */
    public $images;
    /** @var string */
    public $name;
    /** @var int */
    public $popularity;
    /** @var string */
    public $type;
    /** @var string */
    public $uri;

    public function __construct($apiResponseArtist)
    {
        $this->apiResponse = $apiResponseArtist;

        $this->setAttributesFromResponse([
            'id',
            'followers',
            'genres',
            'href',
            'images',
            'name',
            'popularity',
            'type',
            'uri',
        ]);
    }
}
