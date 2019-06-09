<?php

namespace App\Components\MyLibrary;

use App\Artist;
use Illuminate\Support\Collection;

class ArtistByLetterOccurrence implements \JsonSerializable
{
    private $letter;
    private $count;
    private $artists;

    public function __construct($firstLetterOccurrence)
    {
        $this->letter = $firstLetterOccurrence->firstLetter;
        $this->count = $firstLetterOccurrence->count;
    }

    public function loadArtists()
    {
        $this->artists = Artist::ofCurrentUser()
            ->with('tracks.artists')
            ->whereRaw("substr(UPPER(name), 1, 1) = '$this->letter'")
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getLetter()
    {
        return $this->letter;
    }

    public function setLetter($letter): void
    {
        $this->letter = $letter;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count): void
    {
        $this->count = $count;
    }

    /**
     * @return Collection
     */
    public function getArtists()
    {
        return $this->artists;
    }

    public function setArtists($artists): void
    {
        $this->artists = $artists;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}