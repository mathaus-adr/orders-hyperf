<?php

namespace App\Resource;

use Hyperf\Resource\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'codigoPedido' => $this->external_order_id,
            'codigoCliente' => $this->client->external_client_id,
            'itens' => OrderItemResource::collection($this->orderItems),
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
