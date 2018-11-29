<?php

namespace App\Components\Spotify\Import;

use App\Service\Spotify\SpotifyApiService;

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
        $response = $this->apiService->getMySavedAlbums(['limit' => $limit, 'offset' => $offset]);

        return [
            'page' => request('page', 1),
            'from' => $offset,
            'to' => $offset + $limit,
            'limit' => $limit,
            'total' => $response->total,
            'albums' => $this->albumTransformer->transform($response->items)
        ];
    }
}
