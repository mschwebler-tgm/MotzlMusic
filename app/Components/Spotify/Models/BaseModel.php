<?php

namespace App\Components\Spotify\Models;


abstract class BaseModel
{
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
        $this->{$property} = $this->apiResponseTrack->{$responseProperty} ?? null;
    }
}
