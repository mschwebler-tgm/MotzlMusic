<?php

namespace App\Components\Spotify\Models;


abstract class BaseModel
{
    protected $apiResponse;

    public function __construct($apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }

    protected function setAttributesFromResponse(array $attributes)
    {
        foreach ($attributes as $key => $attribute) {
            if (is_string($key)) {
                $this->setAttributeFromResponse($key, $attribute);
            } else {
                $this->setAttributeFromResponse($attribute);
            }
        }
    }

    protected function setAttributeFromResponse(string $property, string $responseProperty = null)
    {
        $responseProperty = $responseProperty ?: $property;
        $this->{$property} = $this->apiResponse->{$responseProperty} ?? null;
    }

    /**
     * @return object
     */
    public function getApiResponse()
    {
        return $this->apiResponse;
    }

    /**
     * @param object $apiResponse
     */
    public function setApiResponse($apiResponse): void
    {
        $this->apiResponse = $apiResponse;
    }
}
