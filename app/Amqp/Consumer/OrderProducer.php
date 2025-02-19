<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use Hyperf\Di\Annotation\Inject;
use Orders\Domain\DataTransferObjects\OrderDataDTO;
use Orders\Domain\Services\CreateOrderService;
use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use PhpAmqpLib\Message\AMQPMessage;

#[Consumer(exchange: 'hyperf', routingKey: 'hyperf', queue: 'hyperf', name: "OrderProducer", nums: 1)]
class OrderProducer extends ConsumerMessage
{

    #[Inject]
    private CreateOrderService $createOrderService;

    public function consumeMessage($data, AMQPMessage $message): Result
    {
        try {
            $this->createOrderService->execute(new OrderDataDTO($data));
            return Result::ACK;
        } catch (\Throwable $th) {
           return Result::REQUEUE;
        }
    }
}