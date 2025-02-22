<?php

namespace App\Resource;

use Hyperf\Resource\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'produto' => $this->name,
            'quantidade' => $this->quantity,
            'preco' => $this->price,
        ];
    }
}
