<?php

namespace app\Infrastructure\Repositories;



use Orders\Domain\DataTransferObjects\OrderDataDTO;
use Orders\Domain\Entities\Client;
use Orders\Domain\Entities\Order;
use App\Model\Order as OrderHyperfModel;
use Orders\Domain\Interfaces\Repositories\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{

    public function create(Client $client, OrderDataDTO $orderDataDTO): Order
    {
        $order = OrderHyperfModel::create([
            'client_id' => $client->id,
            'external_order_id' => $orderDataDTO->orderExternalId,
            'total' => $orderDataDTO->getOrderTotal(),
        ]);

        $orderData = $order->toArray();

        return new Order($orderData);
    }
}