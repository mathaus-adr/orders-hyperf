<?php

namespace HyperfTest;

use Faker\Generator;
use Faker\Provider\Lorem;
use Hyperf\Testing\Client;
use Hyperf\Testing\TestCase;
use function Hyperf\Support\make;

class BaseTestCase extends TestCase
{

    protected $client;

    protected Generator $faker;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $faker = \Faker\Factory::create();
        $faker->addProvider(new Lorem($faker));
        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
        $faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
        $faker->addProvider(new \Faker\Provider\en_US\Company($faker));
        $faker->addProvider(new \Faker\Provider\Lorem($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));
        $this->faker = $faker;
    }
}