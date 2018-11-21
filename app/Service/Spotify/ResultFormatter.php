<?php

namespace App\Service\Spotify;


class ResultFormatter
{
    private $objectToTransform;

    public function __construct($objectToTransform)
    {
        $this->objectToTransform = $objectToTransform;
    }

    public function get(...$props)
    {
        $result = [];
        foreach (func_get_args() as $prop) {
            if (is_array($prop)) {
                foreach ($prop as $propName => $propKeyOverwrite) {
                    $this->pushPropFromObject($result, $this->objectToTransform, $propName, $propKeyOverwrite);
                }
            } else {
                $this->pushPropFromObject($result, $this->objectToTransform, $prop);
            }
        }
        return $result;
    }

    private function pushPropFromObject(&$result, $objectToTransform, $propName, $propKeyOverwrite = null)
    {
        if (str_contains($propName, '.')) {
            $nestedPropName = $this->getFirstNestedProp($propName);
            $this->assureResultKey($result, $nestedPropName);
            $remainingNestedPropNames = $this->getDescendingProperties($propName);
            $nestedObject = $this->getPropFromObject($nestedPropName, $objectToTransform);
            if ($this->isAsteriskWildCard($remainingNestedPropNames)) {
                $propToExtract = $this->getDescendingProperties($remainingNestedPropNames);
                $this->pushAllNestedProps($result[$nestedPropName], $nestedObject, $propToExtract);
            } else {
                if ($propKeyOverwrite) {
                    $this->pushPropFromObject($result, $nestedObject, $remainingNestedPropNames, $propKeyOverwrite);
                } else {
                    $this->pushPropFromObject($result[$nestedPropName], $nestedObject, $remainingNestedPropNames);
                }
            }
        } else {
            $result[$propKeyOverwrite ?: $propName] = $this->getPropFromObject($propName, $objectToTransform);
        }
    }

    private function pushAllNestedProps(&$result, $objectToTransform, $propToExtract)
    {
        foreach ($objectToTransform as $key => $wildCardItem) {
            $this->assureResultKey($result, $key);
            $this->pushPropFromObject($result[$key], $wildCardItem, $propToExtract);
        }
    }

    private function getPropFromObject($propName, $objectToTransform)
    {
        if (is_array($objectToTransform) && preg_match('/\d+/', $propName)) {
            return isset($objectToTransform[(int)$propName]) ? $objectToTransform[(int)$propName] : null;
        }
        return isset($objectToTransform->$propName) ? $objectToTransform->$propName : null;
    }

    /**
     * returns the first nested property found in string
     * ex: artist.nestedObject.name
     * returns: artist
     * @param $prop
     * @return string
     */
    private function getFirstNestedProp($prop)
    {
        return explode('.', $prop)[0];
    }

    private function isAsteriskWildCard($prop)
    {
        return $prop[0] === '*';
    }

    /**
     * @param $propName
     * @return bool|string
     */
    private function getDescendingProperties($propName)
    {
        return substr($propName, strpos($propName, '.') + 1);
    }

    private function assureResultKey(&$result, $key)
    {
        if (!isset($result[$key])) {
            $result[$key] = [];
        }
    }
}
