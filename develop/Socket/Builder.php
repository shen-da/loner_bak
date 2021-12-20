<?php

declare(strict_types=1);

namespace Loner\Socket;

use Loner\Socket\Exception\ServerCreatedException;
use Loner\Utils\Arr;

/**
 * 创建者
 *
 * @package Loner\Socket
 */
class Builder implements BuilderInterface
{
    /**
     * 绑定上下文配置
     *
     * @var array[]
     */
    private array $contextOptions = ['socket' => ['backlog' => ServerInterface::DEFAULT_BACKLOG]];

    public static function socket(): string
    {
        return '';
    }

    /**
     *
     *
     * @param string $host
     * @param int $port
     */
    public function __construct(private string $host, private int $port)
    {
    }

    /**
     * 监听地址
     *
     * @return string
     */
    public function target(): string
    {
        return $this->host . ':' . $this->port;
    }

    /**
     * 绑定上下文配置
     *
     * @param array $options
     */
    public function set(array $options): void
    {
        foreach ($options as $keys => $option) {
            Arr::set($this->contextOptions, $keys, $option);
        }
    }

    public function create()
    {
        $context = stream_context_create($this->contextOptions);
        $socket = stream_socket_server($socketAddress, $errno, $errStr, static::$flags, $context);
        if (!$socket) {
            throw new ServerCreatedException(sprintf('Server[%s] create failed：%d %s', $socketAddress, $errno ?? 0, $errStr ?? ''));
        }
        return '';
    }
}
