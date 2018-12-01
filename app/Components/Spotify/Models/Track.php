<?php

namespace App\Components\Spotify\Models;

use Illuminate\Support\Collection;

class Track extends BaseModel
{
    protected $apiResponseTrack;

    /** @var string */
    protected $id;
    /** @var string */
    protected $name;
    /** @var int */
    protected $duration;
    /** @var boolean */
    protected $explicit;
    /** @var string */
    protected $href;
    /** @var boolean */
    protected $isLocal;
    /** @var boolean */
    protected $isPlayable;
    /** @var integer */
    protected $popularity;
    /** @var string */
    protected $uri;
    /** @var Album */
    protected $album;
    /** @var Collection */
    protected $artists;
    /** @var int */
    protected $discNumber;
    /** @var object */
    protected $externalIds;
    /** @var object */
    protected $externalUrls;
    /** @var string */
    protected $previewUrl;
    /** @var int */
    protected $trackNumber;
    /** @var string */
    protected $type;

    public function __construct($apiResponseTrack)
    {
        $this->apiResponseTrack = $apiResponseTrack;

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

    # ----------------------------
    #      getters and setters
    # ----------------------------

    /**
     * @return mixed
     */
    public function getApiResponseTrack()
    {
        return $this->apiResponseTrack;
    }

    /**
     * @param mixed $apiResponseTrack
     */
    public function setApiResponseTrack($apiResponseTrack): void
    {
        $this->apiResponseTrack = $apiResponseTrack;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return bool
     */
    public function isExplicit(): bool
    {
        return $this->explicit;
    }

    /**
     * @param bool $explicit
     */
    public function setExplicit(bool $explicit): void
    {
        $this->explicit = $explicit;
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @param string $href
     */
    public function setHref(string $href): void
    {
        $this->href = $href;
    }

    /**
     * @return bool
     */
    public function isLocal(): bool
    {
        return $this->isLocal;
    }

    /**
     * @param bool $isLocal
     */
    public function setIsLocal(bool $isLocal): void
    {
        $this->isLocal = $isLocal;
    }

    /**
     * @return bool
     */
    public function isPlayable(): bool
    {
        return $this->isPlayable;
    }

    /**
     * @param bool $isPlayable
     */
    public function setIsPlayable(bool $isPlayable): void
    {
        $this->isPlayable = $isPlayable;
    }

    /**
     * @return int
     */
    public function getPopularity(): int
    {
        return $this->popularity;
    }

    /**
     * @param int $popularity
     */
    public function setPopularity(int $popularity): void
    {
        $this->popularity = $popularity;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    /**
     * @return Album
     */
    public function getAlbum(): Album
    {
        return $this->album;
    }

    /**
     * @param Album $album
     */
    public function setAlbum(Album $album): void
    {
        $this->album = $album;
    }

    /**
     * @return Collection
     */
    public function getArtists(): Collection
    {
        return $this->artists;
    }

    /**
     * @param Collection $artists
     */
    public function setArtists(Collection $artists): void
    {
        $this->artists = $artists;
    }

    /**
     * @return int
     */
    public function getDiscNumber(): int
    {
        return $this->discNumber;
    }

    /**
     * @param int $discNumber
     */
    public function setDiscNumber(int $discNumber): void
    {
        $this->discNumber = $discNumber;
    }

    /**
     * @return object
     */
    public function getExternalIds(): object
    {
        return $this->externalIds;
    }

    /**
     * @param object $externalIds
     */
    public function setExternalIds(object $externalIds): void
    {
        $this->externalIds = $externalIds;
    }

    /**
     * @return object
     */
    public function getExternalUrls(): object
    {
        return $this->externalUrls;
    }

    /**
     * @param object $externalUrls
     */
    public function setExternalUrls(object $externalUrls): void
    {
        $this->externalUrls = $externalUrls;
    }

    /**
     * @return string
     */
    public function getPreviewUrl(): string
    {
        return $this->previewUrl;
    }

    /**
     * @param string $previewUrl
     */
    public function setPreviewUrl(string $previewUrl): void
    {
        $this->previewUrl = $previewUrl;
    }

    /**
     * @return int
     */
    public function getTrackNumber(): int
    {
        return $this->trackNumber;
    }

    /**
     * @param int $trackNumber
     */
    public function setTrackNumber(int $trackNumber): void
    {
        $this->trackNumber = $trackNumber;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }
}
