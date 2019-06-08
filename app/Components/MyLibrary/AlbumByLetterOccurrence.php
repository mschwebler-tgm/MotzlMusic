<?php

namespace App\Components\MyLibrary;

use App\Album;

class AlbumByLetterOccurrence implements \JsonSerializable
{
    private $letter;
    private $count;
    private $albums;

    public function __construct($firstLetterOccurrence)
    {
        $this->letter = $firstLetterOccurrence->firstLetter;
        $this->count = $firstLetterOccurrence->count;
    }

    public function loadAlbums()
    {
        $this->albums = Album::ofCurrentUser()
            ->with('tracks.artists')
            ->whereRaw("substr(UPPER(name), 1, 1) = '$this->letter'")
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getLetter()
    {
        return $this->letter;
    }

    public function setLetter($letter)
    {
        $this->letter = $letter;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count)
    {
        $this->count = $count;
    }

    public function getAlbums()
    {
        return $this->albums;
    }

    public function setAlbums($albums)
    {
        $this->albums = $albums;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
