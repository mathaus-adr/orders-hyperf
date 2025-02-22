<?php
declare(strict_types=1);

use Faker\Provider\Lorem;
use Hyperf\Database\Seeders\Seeder;
use App\Model\Client;
use App\Model\Order;
use App\Model\OrderItem;
use Hyperf\Database\Model\Factory;

class OrderSeeder extends Seeder
{
    private Factory $factory;
    private \Faker\Generator $faker;


    public function run(): void
    {
        $this->initDependencies();
        $this->defineClientFactory();
        $this->defineOrderItemFactory();
        $this->defineOrderFactory();


        $orders = $this->factory->of(Order::class)->times(5)->create();

        foreach ($orders as $order) {
            for ($i = 0; $i < 5; $i++) {
                $this->factory->create(OrderItem::class, ['order_id' => $order->id]);
            }
        }
    }


    /**
     * Define a factory for creating Client models.
     */
    private function defineClientFactory(): void
    {
        $this->factory->define(Client::class, function (Faker\Generator $faker) {
            return [
                'external_client_id' => $faker->randomNumber(4),
                'order_quantity' => 0
            ];
        });
    }

    /**
     * Define a factory for creating Order models.
     */
    private function defineOrderFactory(): void
    {
        $this->factory->define(Order::class, function (Faker\Generator $faker) {
            return [
                'external_order_id' => $faker->randomNumber(4),
                'total' => $faker->randomFloat(2, 50.00, 500.00),
                'client_id' => $this->factory->create(Client::class)->id
            ];
        });
    }

    /**
     * Define a factory for creating OrderItem models.
     */
    private function defineOrderItemFactory(): void
    {
        $this->factory->define(OrderItem::class, function (Faker\Generator $faker) {
            return [
                'name' => $faker->words(3, true),
                'quantity' => $faker->numberBetween(1, 99),
                'price' => $faker->randomFloat(2, 1.00, 100.00)
            ];
        });
    }

    /**
     * @return void
     */
    public function initDependencies(): void
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new Lorem($faker));
        $faker->addProvider(new Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new Faker\Provider\en_US\Address($faker));
        $faker->addProvider(new Faker\Provider\en_US\PhoneNumber($faker));
        $faker->addProvider(new Faker\Provider\en_US\Company($faker));
        $faker->addProvider(new Faker\Provider\Lorem($faker));
        $faker->addProvider(new Faker\Provider\Internet($faker));
        $this->faker = $faker;
        $this->factory = Factory::construct($faker);
    }
}