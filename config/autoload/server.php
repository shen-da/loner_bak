<?php

declare(strict_types=1);

return [
    // 守护进程模式
    'daemonize' => false,

    // 服务器列表
    'servers' => [
        [
            'name' => 'http',
//            'type' => Server::SERVER_HTTP,
            'host' => '0.0.0.0',
            'port' => 9501,
//            'sock_type' => SWOOLE_SOCK_TCP,
            'callbacks' => [
//                Event::ON_REQUEST => [Hyperf\HttpServer\Server::class, 'onRequest'],
            ],
        ],
    ]
];