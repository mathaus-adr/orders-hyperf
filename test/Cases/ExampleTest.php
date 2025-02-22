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

namespace HyperfTest\Cases;

use App\Amqp\Consumer\OrderProducer;
use App\Model\Client;
use App\Model\Order;
use App\Model\OrderItem;
use Hyperf\Context\ApplicationContext;

//use Hyperf\Testing\TestCase;
use HyperfTest\BaseTestCase;
use PhpAmqpLib\Message\AMQPMessage;


/**
 * @internal
 * @coversNothing
 */
class ExampleTest extends BaseTestCase
{

    public function testExample()
    {
        $container = ApplicationContext::getContainer();
        $orderProducer = $container->get(OrderProducer::class);
        $amqpMessage = $container->get(AMQPMessage::class);
        $data = [
            'codigoPedido' => $this->faker->numberBetween(3000, 9000),
            'codigoCliente' => $this->faker->numberBetween(3000, 9000),
            'itens' => [
                [
                    'produto' => $this->faker->word,
                    'quantidade' => $this->faker->randomFloat(2, 10, 1000),
                    'preco' => $this->faker->randomFloat(2, 10, 1000)
                ],
                [
                    'produto' => $this->faker->word,
                    'quantidade' => $this->faker->randomFloat(2, 10, 1000),
                    'preco' => $this->faker->randomFloat(2, 10, 1000)
                ]
            ]
        ];

        $orderProducer->consumeMessage($data, $amqpMessage);

        $client = Client::query()->where('external_client_id', $data['codigoCliente'])->first();


        $this->assertDatabaseHas('clients', [
            'external_client_id' => $data['codigoCliente']
        ]);

        $this->assertDatabaseHas('orders', [
            'external_order_id' => $data['codigoPedido'],
            'client_id' => $client->id,
            'total' => array_sum(array_column($data['itens'], 'preco'))
        ]);

        $order = Order::query()->where('external_order_id', $data['codigoPedido'])->first();

        foreach ($data['itens'] as $item) {
            $this->assertDatabaseHas('order_items', [
                'name' => $item['produto'],
                'quantity' => $item['quantidade'],
                'price' => $item['preco'],
                'order_id' => $order->id
            ]);
        }


        $this->get('/clients/' . $data['codigoCliente'] . '/orders')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['*' => [
                    'codigoPedido',
                    'codigoCliente',
                    'total',
                    'itens' => [
                        '*' => [
                            'produto',
                            'quantidade',
                            'preco'
                        ]
                    ]
                ]],
                'quantidade',
                'links',
                'meta'
            ]);

        $queryString = [
            'codigoCliente' => $data['codigoCliente'],
            'codigoPedido' => $data['codigoPedido']
        ];

        $this->get('orders?'.http_build_query($queryString))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'codigoPedido',
                        'codigoCliente',
                        'total',
                        'itens' => [
                            '*' => [
                                'produto',
                                'quantidade',
                                'preco'
                            ]
                        ]
                    ]
                ]
            ]);
    }
}
