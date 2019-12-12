<?php

namespace App\Components\MyLibrary;

use App\Playlist;
use App\Track;
use App\User;

class MyLibraryDao
{
    /** @var User */
    private $user;

    public function __construct()
    {
        $this->user = apiUser();
    }

    public function getAllTracks()
    {
        return Track::with('artists', 'album', 'audioFeatures')
            ->orderBy('name', 'asc')->get();
    }

    public function addTrack($id)
    {
        apiUser()->tracks()->attach($id);
    }

    public function removeTrack($id)
    {
        apiUser()->tracks()->detach([$id]);
    }
}
