<?php

namespace App\Components\Spotify\Import;

use App\Service\Spotify\SpotifyApiService;
use Illuminate\Support\Facades\Cache;

class PlaylistService
{
    private $apiService;
    private $playlistTransformer;

    public function __construct(SpotifyApiService $apiService, PlaylistTransformer $playlistTransformer)
    {
        $this->apiService = $apiService;
        $this->playlistTransformer = $playlistTransformer;
    }

    public function paginate()
    {
        $limit = request('limit', 20);
        $offset = (request('page', 1) - 1) * $limit;
        $response = $this->getPlaylists($limit, $offset);

        return [
            'page' => request('page', 1),
            'from' => $offset,
            'to' => $offset + $limit,
            'limit' => $limit,
            'total' => $response->total,
            'items' => $this->playlistTransformer->transform($response->items)
        ];
    }

    private function getPlaylists($limit, $offset)
    {
        $cacheKey = __METHOD__ . "limit$limit-offset$offset";
        $response = Cache::get($cacheKey);
        if (!$response) {
            $response = $this->apiService->getMyPlaylists(['limit' => $limit, 'offset' => $offset]);
            Cache::put($cacheKey, $response, 3);
        }

        return $response;
    }
}
