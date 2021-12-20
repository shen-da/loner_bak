<?php

declare(strict_types=1);

namespace Loner\Http\Server;

use Closure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 标准中间件
 *
 * @package Loner\Http\Server
 */
class Middleware implements MiddlewareInterface
{
    /**
     * 数值列表
     *
     * @var string[]
     */
    private array $values;

    /**
     * 初始化
     *
     * @param Closure $next
     * @param string ...$values
     */
    final public function __construct(private Closure $next, string ...$values)
    {
        $this->values = $values;
    }

    /**
     * 获取数值列表
     *
     * @return string[]
     */
    final public function values(): array
    {
        return $this->values;
    }

    /**
     * 请求处理程序
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    final public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $result = $this->requestHandle($request);

        if ($result instanceof ResponseInterface) {
            return $result;
        }

        $response = call_user_func($this->next, $result, $handler);

        return $this->responseHandle($response);
    }

    /**
     * 获取数值
     *
     * @param int $pos
     * @return string|null
     */
    final protected function value(int $pos): ?string
    {
        return $this->values[$pos] ?? null;
    }

    /**
     * 请求处理
     *
     * @param ServerRequestInterface $request
     * @return ServerRequestInterface|ResponseInterface
     */
    protected function requestHandle(ServerRequestInterface $request): ServerRequestInterface|ResponseInterface
    {
        return $request;
    }

    /**
     * 响应处理
     *
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    protected function responseHandle(ResponseInterface $response): ResponseInterface
    {
        return $response;
    }
}
