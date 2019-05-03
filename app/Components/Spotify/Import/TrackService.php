<?php

namespace App\Components\Spotify\Import;

use App\Service\Spotify\SpotifyApiService;
use Illuminate\Support\Facades\Cache;

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
        $response = $this->getSavedTracks($limit, $offset);

        return [
            'page' => request('page', 1),
            'from' => $offset,
            'to' => $offset + $limit,
            'limit' => $limit,
            'total' => $response->total,
            'items' => $this->trackTransformer->transform($response->items)
        ];
    }

    private function getSavedTracks($limit, $offset)
    {
        $cacheKey = __METHOD__ . "limit$limit-offset$offset";
        $response = Cache::get($cacheKey);
        if (!$response) {
            $response = $this->apiService->getMySavedTracks(['limit' => $limit, 'offset' => $offset]);
            Cache::put($cacheKey, $response, 3);
        }

        return $response;
    }
}
