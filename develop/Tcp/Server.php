<?php

declare(strict_types=1);

namespace Loner\Tcp;

use Loner\Socket\Server as SocketServer;

/**
 * 基于 tcp 协议的服务器
 *
 * @package Loner\Tcp
 */
class Server extends SocketServer
{
    /**
     * 传输协议
     *
     * @return string
     */
    public static function transport(): string
    {
        return 'tcp';
    }
}
