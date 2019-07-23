<?php

namespace App\Components\Deezer;

use App\Service\GenericDaos\Exceptions\TrackNotFoundException;
use App\Service\GenericDaos\TrackDao;
use Log;

class DeezerDownloader
{
    private $trackDao;
    private $deezerClient;

    public function __construct(TrackDao $trackDao, DeezerClient $deezerClient)
    {
        $this->trackDao = $trackDao;
        $this->deezerClient = $deezerClient;
    }

    /**
     * @param $id
     * @return bool
     * @throws TrackNotFoundException
     */
    public function downloadTrack($id)
    {
        $track = $this->trackDao->get($id);
        if (!$track->isrc) {
            return Log::info("Track could not be downloaded (isrc missing). ID: $track->id");
        }

        $scriptPath = $this->getDownloadScriptPath();
        $deezerUrl = $this->deezerClient->getDeezerTrackUrl($track->isrc);
        $output = exec("python3 $scriptPath --link $deezerUrl -q 2");
        dd($output);
    }

    /**
     * @return string
     */
    protected function getDownloadScriptPath(): string
    {
        return __DIR__ . '/script/deezpy.py';
    }
}
