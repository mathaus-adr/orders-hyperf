<?php

return [
    'enable' => true,
    'default' => [
        'host' => 'rabbitmq',
        'port' => 5672,
        'user' => 'admin',
        'password' => 'admin',
        'vhost' => '/',
        'concurrent' => [
            'limit' => 1,
        ],
        'pool' => [
            'connections' => 1,
        ],
        'params' => [
            'insist' => false,
            'login_method' => 'AMQPLAIN',
            'login_response' => null,
            'locale' => 'en_US',
            'connection_timeout' => 30.0,
            // Try to maintain twice value heartbeat as much as possible
            'read_write_timeout' => 30.0,
            'context' => null,
            'keepalive' => false,
            // Try to ensure that the consumption time of each message is less than the heartbeat time as much as possible
            'heartbeat' => 15,
            'close_on_destruct' => false,
        ],
    ]
];
