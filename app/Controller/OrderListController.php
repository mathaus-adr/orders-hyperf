<?php

declare(strict_types=1);

namespace App\Controller;

use App\Resource\Orders;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Orders\Domain\Services\ListOrdersService;

class OrderListController extends AbstractController
{

    #[Inject]
    private ListOrdersService $listOrdersService;

    public function index(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        return (new Orders($this->listOrdersService->execute()))->toResponse();
    }
}
