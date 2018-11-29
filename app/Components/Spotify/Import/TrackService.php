<?php

namespace App\Components\Spotify\Import;

use App\Service\Spotify\SpotifyApiService;

class TrackService
{
    private $apiService;
    private $trackTransformer;

    public function __construct(SpotifyApiService $apiService, TrackTransformer $trackTransformer)
    {
        $this->apiService = $apiService;
        $this->trackTransformer = $trackTransformer;
    }

    public function paginate()
    {
        $limit = request('limit', 20);
        $offset = (request('page', 1) - 1) * $limit;
        $response = $this->apiService->getMySavedTracks(['limit' => $limit, 'offset' => $offset]);

        return [
            'page' => request('page', 1),
            'from' => $offset,
            'to' => $offset + $limit,
            'limit' => $limit,
            'total' => $response->total,
            'items' => $this->trackTransformer->transform($response->items)
        ];
    }
}
