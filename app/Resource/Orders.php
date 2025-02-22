<?php

namespace App\Resource;

use Hyperf\Resource\Json\ResourceCollection;

class Orders extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => $this->collection,
            'quantidade' => $this->collection->count(),
        ];
    }
}
