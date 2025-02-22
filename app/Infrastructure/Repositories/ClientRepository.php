<?php

namespace App\Infrastructure\Repositories;

use App\Model\Client as ClientHyperfModel;
use Hyperf\DbConnection\Db;
use Orders\Domain\Entities\Client;

use Orders\Domain\Interfaces\Repositories\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{

    public function find(string $clientExternalId): ?Client
    {
        $client = ClientHyperfModel::query()->where('external_client_id', $clientExternalId)->first();

        if ($client === null) {
            return null;
        }

        $clientData = $client->toArray();
        return new Client($clientData);
    }

    public function create(string $clientExternalId): Client
    {
        $client = ClientHyperfModel::create([
            'external_client_id' => $clientExternalId
        ]);

        $clientData = $client->toArray();
        return new Client($clientData);
    }

    public function updateClientTotalOrders(Client $client): void
    {
        $clientQuery = ClientHyperfModel::query()->where('external_client_id', $client->id);

        $clientQuery->update([
            'order_quantity' => Db::raw('order_quantity + 1')
        ]);
    }
}