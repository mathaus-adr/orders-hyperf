<?php

declare(strict_types=1);

namespace App\Controller;

use App\Resource\Orders;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Orders\Domain\Services\ClientOrderListService;
use Psr\Http\Message\ResponseInterface;

class ClientOrderListController extends AbstractController
{
    #[Inject]
    private ClientOrderListService $clientOrderListService;

    public function index(): ResponseInterface
    {
        return (new Orders($this->clientOrderListService->execute(
            externalClientId: $this->request->route('client_id')
        )))->toResponse();
    }
}
