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

    public function addTrack($id)
    {
        apiUser()->tracks()->attach($id);
    }

    public function removeTrack($id)
    {
        apiUser()->tracks()->detach([$id]);
    }
}
