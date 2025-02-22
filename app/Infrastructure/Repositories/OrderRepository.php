<?php

namespace app\Infrastructure\Repositories;


use Hyperf\Contract\LengthAwarePaginatorInterface;
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

    public function getOrderListPaginatedByExternalClientId(string $externalClientId): LengthAwarePaginatorInterface
    {
        return OrderHyperfModel::query()->join('clients', 'orders.client_id', '=', 'clients.id')
            ->where('clients.external_client_id', $externalClientId)
            ->select(['orders.*'])->with(['orderItems'])->paginate();
    }

    public function getOrderListByParam(string $externalOrderId = null, string $externalClientId = null): LengthAwarePaginatorInterface
    {
        return OrderHyperfModel::query()->join('clients', 'orders.client_id', '=', 'clients.id')
            ->when($externalClientId, function ($query) use ($externalClientId) {
                return $query->where('clients.external_client_id', $externalClientId);
            })
            ->when($externalOrderId, function ($query) use ($externalOrderId) {
                return $query->where('orders.external_order_id', $externalOrderId);
            })
            ->select(['orders.*'])->with(['orderItems'])->paginate();
    }
}