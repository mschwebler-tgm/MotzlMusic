<?php

namespace App\Components\Deezer;

use GuzzleHttp\Client;
use Log;

class DeezerClient
{
    const API_TRACK_BY_ISCR_URL = 'https://api.deezer.com/track/isrc:';

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getDeezerTrackUrl($isrc)
    {
        $apiUrl = self::API_TRACK_BY_ISCR_URL . $isrc;
        $responseBody = $this->requestTrackData($apiUrl);

        if (!is_object($responseBody)) {
            return null;
        }

        return $responseBody->link;
    }

    private function requestTrackData($url)
    {
        $response = $this->client->get($url);
        $responseBody = json_decode($response->getBody()->getContents());
        if ($response->getStatusCode() !== 200) {
            return Log::info(
                "Deezer api request failed with status code {$response->getStatusCode()}. ($url)",
                (array)$responseBody
            );
        }
        if (isset($responseBody->error)) {
            return Log::info("Deezer api request failed. ($url)", (array)$responseBody);
        }

        return $responseBody;
    }
}