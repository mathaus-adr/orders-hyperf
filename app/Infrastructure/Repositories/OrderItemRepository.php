<?php

namespace App\Infrastructure\Repositories;

use App\Model\OrderItem as OrderItemHyperfModel;
use Orders\Domain\DataTransferObjects\OrderItemDataDTO;
use Orders\Domain\Entities\Order;
use Orders\Domain\Entities\OrderItem;
use Orders\Domain\Interfaces\Repositories\OrderItemRepositoryInterface;

class OrderItemRepository implements OrderItemRepositoryInterface
{

    public function create(Order $order, OrderItemDataDTO $orderItemDataDTO): OrderItem
    {
        $orderItem = OrderItemHyperfModel::create([
            'order_id' => $order->id,
            'name' => $orderItemDataDTO->sku,
            'price' => $orderItemDataDTO->price,
            'quantity' => $orderItemDataDTO->quantity,
        ]);

        $orderItemData = $orderItem->toArray();

        return new OrderItem($orderItemData);
    }
}