<?php

namespace App\Http\Controllers;

use App\Components\Upload\SingleUploadRequest;
use App\Components\Upload\SpotifyMatcher;

class UploadController extends Controller
{
    public function uploadTrack(SingleUploadRequest $request, SpotifyMatcher $spotifyMatcher)
    {
        $trackName = $request->getFileName();
        $spotifyTrack = $spotifyMatcher->getEstimatedSpotifyMatch($trackName);
        dd($spotifyTrack);
//        $a = $mp3File->store(apiUser()->mp3StoragePath());
        return response(null, 200);
    }
}
