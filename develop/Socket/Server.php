<?php

declare(strict_types=1);

namespace Loner\Socket;

use Loner\Socket\Exception\ServerCreatedException;

class Server implements ServerInterface
{
    /**
     * 监听网络标志组合
     *
     * @var int
     */
    protected static int $flags = STREAM_SERVER_BIND | STREAM_SERVER_LISTEN;

    /**
     * 监听网络地址
     *
     * @var string
     */
    private string $target;

    /**
     * 资源流上下文配置
     *
     * @var array
     */
    private array $contextOptions = [];

    /**
     * 资源流上下文
     *
     * @var resource|null
     */
    private $context = null;

    /**
     * 主套接字
     *
     * @var resource
     */
    protected $socket = null;

    /**
     * 初始化资源流上下文
     *
     * @param string $target
     * @param array $options
     */
    public function __construct(string $target, array $options = [])
    {
        $this->target = $target;
        $this->contextualize($options);
    }

    /**
     * 资源流上下文配置
     *
     * @param array $options
     */
    public function contextualize(array $options): void
    {
        if ($options === $this->contextOptions) {
            return;
        }

        $this->contextOptions = $options;
        $this->context = stream_context_create(array_merge_recursive(['socket' => ['backlog' => self::DEFAULT_BACKLOG]], $options));
    }

    /**
     * @inheritDoc
     */
    public function target(): string
    {
        return $this->target;
    }

    /**
     * @inheritDoc
     */
    public function create(): void
    {
        if ($this->socket === null) {
            $socketAddress = static::transport() . '://' . $this->target();
            $this->socket = stream_socket_server($socketAddress, $errno, $errStr, static::$flags, $this->context) ?: null;
            if ($this->socket === null) {
                throw new ServerCreatedException(sprintf('Server[%s] create failed：%d %s', $socketAddress, $errno ?? 0, $errStr ?? ''));
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function close(): void
    {
        fclose($this->socket);
        $this->socket = null;
    }
}
