<?php

namespace App\Components\Spotify\Import;

use App\Service\Spotify\SpotifyApiService;

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
        $response = $this->apiService->getMyPlaylists(['limit' => $limit, 'offset' => $offset]);

        return [
            'page' => request('page', 1),
            'from' => $offset,
            'to' => $offset + $limit,
            'limit' => $limit,
            'total' => $response->total,
            'items' => $this->playlistTransformer->transform($response->items)
        ];
    }
}