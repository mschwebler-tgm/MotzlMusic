<?php

namespace App\Components\Spotify\Models;

use App\Components\Spotify\Models\Traits\HasTracks;
use Illuminate\Support\Collection;

class Playlist extends BaseModel
{
    use HasTracks;

    /** @var string */
    public $id;
    /** @var boolean */
    public $collaborative;
    /** @var string */
    public $description;
    /** @var object */
    public $followers;
    /** @var string */
    public $href;
    /** @var array */
    public $images;
    /** @var string */
    public $name;
    /** @var object */
    public $owner;
    /** @var boolean */
    public $isPublic;
    /** @var string */
    public $snapshotId;
    /** @var string|null */
    public $primaryColor;
    /** @var object */
    public $externalUrls;
    /** @var string */
    public $type;
    /** @var string */
    public $uri;
    /** @var Collection */
    public $tracks;

    public function __construct($apiResponsePlaylist)
    {
        parent::__construct($apiResponsePlaylist);

        $playlistTracksResponse = $this->pluckTracksFromPlaylistResponse($apiResponsePlaylist);
        $this->setTracksFromApiResponse($playlistTracksResponse);

        $this->setAttributesFromResponse([
            'id',
            'collaborative',
            'description',
            'followers',
            'href',
            'images',
            'name',
            'owner',
            'isPublic' => 'public',
            'snapshotId' => 'snapshot_id',
            'primaryColor' => 'primary_color',
            'externalUrls' => 'external_urls',
            'type',
            'uri',
        ]);
    }

    private function pluckTracksFromPlaylistResponse($apiResponsePlaylist)
    {
        $tracks = [];
        foreach ($apiResponsePlaylist->tracks->items as $trackResponse) {
            $tracks[] = $trackResponse->track;
        }
        return $tracks;
    }
}
