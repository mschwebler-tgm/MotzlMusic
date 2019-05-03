<?php

namespace App\Components\Spotify\Import;

use App\Service\Spotify\SpotifyApiService;
use App\Transformer\Transformable;
use Illuminate\Support\Facades\Cache;

abstract class AbstractSpotifyDataService
{
    /** @var SpotifyApiService */
    protected $apiService;
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
        $cacheKey = __METHOD__ . $this->getApiServiceMethod() . "limit$limit-offset$offset";
        $response = Cache::get($cacheKey);
        if (!$response) {
            $apiServiceMethod = $this->getApiServiceMethod();
            $response = $this->apiService->$apiServiceMethod(['limit' => $limit, 'offset' => $offset]);
            Cache::put($cacheKey, $response, 3);
        }

        return $response;
    }

    abstract protected function getApiServiceMethod();
}
