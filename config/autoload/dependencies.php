<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use App\Infrastructure\Repositories\ClientRepository;
use App\Infrastructure\Repositories\OrderItemRepository;
use App\Infrastructure\Repositories\OrderRepository;
use Orders\Domain\Interfaces\Repositories\ClientRepositoryInterface;
use Orders\Domain\Interfaces\Repositories\OrderItemRepositoryInterface;
use Orders\Domain\Interfaces\Repositories\OrderRepositoryInterface;

return [
    OrderRepositoryInterface::class => OrderRepository::class,
    OrderItemRepositoryInterface::class => OrderItemRepository::class,
    ClientRepositoryInterface::class => ClientRepository::class,
];
