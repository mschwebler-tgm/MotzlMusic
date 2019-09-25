<?php

namespace App\Components\Spotify\Import;

use App\Components\Spotify\Api\SpotifyApi;
use App\Transformer\Transformable;
use Illuminate\Support\Facades\Cache;

abstract class AbstractSpotifyDataService
{
    /** @var SpotifyApi */
    protected $spotifyApi;
    /** @var Transformable */
    protected $transformer;

    const API_SERVICE_METHOD = null;

    public function paginate()
    {
        $limit = request('limit', 20);
        $offset = (request('page', 1) - 1) * $limit;
        $response = $this->getData($limit, $offset);

        return [
            'page' => request('page', 1),
            'from' => $offset,
            'to' => $offset + $limit,
            'limit' => $limit,
            'total' => $response->total,
            'items' => $this->transformer->transform($response->items)
        ];
    }

    private function getData($limit, $offset)
    {
        $userId = apiUser()->id;
        $cacheKey = __METHOD__ . $this->getApiServiceMethod() . "user$userId-limit$limit-offset$offset";
        $response = Cache::get($cacheKey);
        if (!$response) {
            $apiServiceMethod = $this->getApiServiceMethod();
            $response = $this->spotifyApi->$apiServiceMethod(['limit' => $limit, 'offset' => $offset]);
            Cache::put($cacheKey, $response, 3);
        }

        return $response;
    }

    abstract protected function getApiServiceMethod();
}
