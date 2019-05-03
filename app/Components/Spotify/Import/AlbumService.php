<?php

namespace App\Components\Spotify\Import;

use App\Service\Spotify\SpotifyApiService;
use Illuminate\Support\Facades\Cache;

class AlbumService
{
    private $apiService;
    private $albumTransformer;

    public function __construct(SpotifyApiService $apiService, AlbumTransformer $trackTransformer)
    {
        $this->apiService = $apiService;
        $this->albumTransformer = $trackTransformer;
    }

    public function paginate()
    {
        $limit = request('limit', 20);
        $offset = (request('page', 1) - 1) * $limit;
        $response = $this->getSavedAlbums($limit, $offset);

        return [
            'page' => request('page', 1),
            'from' => $offset,
            'to' => $offset + $limit,
            'limit' => $limit,
            'total' => $response->total,
            'items' => $this->albumTransformer->transform($response->items)
        ];
    }

    private function getSavedAlbums($limit, $offset)
    {
        $cacheKey = __METHOD__ . "limit$limit-offset$offset";
        $response = Cache::get($cacheKey);
        if (!$response) {
            $response = $this->apiService->getMySavedAlbums(['limit' => $limit, 'offset' => $offset]);
            Cache::put($cacheKey, $response, 3);
        }

        return $response;
    }
}
