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
            Log::info("Track could not be downloaded (isrc missing). ID: $track->id");
            return false;
        }

        $deezerUrl = $this->deezerClient->getDeezerTrackUrl($track->isrc);
        $filePath = $this->fetchFile($deezerUrl);

        return $this->trackDao->updateLocalPath($track, $filePath);
    }

    /**
     * @return string
     */
    protected function getDownloadScriptPath(): string
    {
        return __DIR__ . '/script/deezpy.py';
    }

    /**
     * @param $deezerUrl
     * @return mixed|string
     */
    protected function fetchFile($deezerUrl)
    {
        $scriptPath = $this->getDownloadScriptPath();
        $filePath = exec("python3 $scriptPath --link $deezerUrl -q 2");
        $filePath = str_replace(storage_path('app/'), '', $filePath);

        return str_replace(' already exists!', '', $filePath);
    }
}
