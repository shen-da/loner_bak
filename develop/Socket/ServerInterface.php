<?php

declare(strict_types=1);

namespace Loner\Socket;

use Loner\Socket\Exception\ServerCreatedException;

interface ServerInterface
{
    /**
     * 默认挂起连接数量上限
     */
    public const DEFAULT_BACKLOG = 102400;

    /**
     * 返回传输协议
     *
     * @return string
     */
    public static function transport(): string;

    /**
     * 返回监听地址
     *
     * @return string
     */
    public function target(): string;

    /**
     * 创建监听网络
     *
     * @throws ServerCreatedException
     */
    public function create(): void;

    /**
     * 接受客户端信息
     *
     * @return array
     */
    public function accept(): array;

    /**
     * 关闭套接字流资源
     */
    public function close(): void;
}
