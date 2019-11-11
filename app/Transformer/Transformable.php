<?php

namespace App\Transformer;

use Illuminate\Support\Collection;

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

    protected function pluckIdAndName(Collection $items)
    {
        return $items->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
            ];
        })->toArray();
    }

    abstract protected function transformItem($item);
}
