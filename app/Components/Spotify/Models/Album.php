<?php

namespace App\Components\Spotify\Models;

use App\Components\Spotify\Models\Traits\HasArtists;
use App\Components\Spotify\Models\Traits\HasTracks;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class Album extends BaseModel
{
    use HasArtists, HasTracks;

    /** @var string */
    public $albumType;
    /** @var array */
    public $copyrights;
    /** @var object */
    public $externalIds;
    /** @var object */
    public $externalUrls;
    /** @var array */
    public $genres;
    /** @var string */
    public $href;
    /** @var string */
    public $id;
    /** @var array */
    public $images;
    /** @var string */
    public $label;
    /** @var string */
    public $name;
    /** @var int */
    public $popularity;
    /** @var Carbon */
    public $releaseDate;
    /** @var string */
    public $releaseDatePrecision;
    /** @var */
    public $totalTracks;
    /** @var string */
    public $type;
    /** @var string */
    public $uri;
    /** @var Collection */
    public $artists;
    /** @var Collection */
    public $tracks;

    public function __construct($apiResponseAlbum)
    {
        $this->apiResponse = $apiResponseAlbum;

        $this->setAttributesFromResponse([
            'albumType' => 'album_type',
            'copyrights',
            'externalIds' => 'external_ids',
            'externalUrls' => 'external_urls',
            'genres',
            'href',
            'id',
            'images',
            'label',
            'name',
            'popularity',
            'releaseDatePrecision' => 'release_date_precision',
            'totalTracks' => 'total_tracks',
            'type',
            'uri',
        ]);

        $this->setTracksFromApiResponse($apiResponseAlbum->tracks->items ?? null);
        $this->setArtistsFromResponse($apiResponseAlbum->artists ?? null);
        $this->setReleaseDateFromResponse($apiResponseAlbum->release_date ?? null);
    }

    private function setReleaseDateFromResponse($release_date)
    {
        $this->releaseDate = $release_date ? new Carbon($release_date) : null;
    }
}
