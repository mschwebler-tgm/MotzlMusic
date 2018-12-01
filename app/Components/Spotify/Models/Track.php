<?php

namespace App\Components\Spotify\Models;

use Illuminate\Support\Collection;

class Track extends BaseModel
{
    /** @var string */
    public $id;
    /** @var string */
    public $name;
    /** @var int */
    public $duration;
    /** @var boolean */
    public $explicit;
    /** @var string */
    public $href;
    /** @var boolean */
    public $isLocal;
    /** @var boolean */
    public $isPlayable;
    /** @var integer */
    public $popularity;
    /** @var string */
    public $uri;
    /** @var Album */
    public $album;
    /** @var Collection */
    public $artists;
    /** @var int */
    public $discNumber;
    /** @var object */
    public $externalIds;
    /** @var object */
    public $externalUrls;
    /** @var string */
    public $previewUrl;
    /** @var int */
    public $trackNumber;
    /** @var string */
    public $type;

    public function __construct($apiResponseTrack)
    {
        $this->apiResponse = $apiResponseTrack;

        $this->setAlbumFromResponse($apiResponseTrack->album);
        $this->setArtistsFromResponse($apiResponseTrack->artists);

        $this->setAttributesFromResponse([
            'id',
            'name',
            'duration' => 'duration_ms',
            'explicit',
            'href',
            'isLocal' => 'is_local',
            'isPlayable' => 'is_playable',
            'popularity',
            'uri',
            'discNumber' => 'disc_number',
            'externalIds' => 'external_ids',
            'externalUrls' => 'external_urls',
            'previewUrl' => 'previewUrl',
            'trackNumber' => 'track_number',
            'type',
        ]);
    }

    private function setAlbumFromResponse($album): void
    {
        $this->album = new Album($album);
    }

    public function setArtistsFromResponse(array $artists): void
    {
        $artistCollection = collect();
        foreach ($artists as $artist) {
            $artistCollection->push(new Artist($artist));
        }
        $this->artists = $artistCollection;
    }
}
