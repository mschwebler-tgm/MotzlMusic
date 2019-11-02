<?php

namespace App\Transformer;

abstract class Transformable
{
    public function transform($content) {
        $data = [];
        if (is_iterable($content)) {
            foreach ($content as $item) {
                $data[] = $this->transformItem($item);
            }
        } else {
            $data = $this->transformItem($content);
        }

        return $data;
    }

    abstract protected function transformItem($item);
}
