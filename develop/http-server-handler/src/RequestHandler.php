<?php

declare(strict_types=1);

namespace Loner\Http\Server;

use Closure;
use Loner\Container\ContainerInterface;
use Loner\Container\Exception\{NotFoundException, ResolvedException};
use Loner\Http\Message\Response;
use Loner\Http\Message\Stream\Stream;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\RequestHandlerInterface;

/**
 * http 服务端处理客户端请求程序
 *
 * @package Loner\Http\Server
 */
class RequestHandler implements RequestHandlerInterface
{
    /**
     * 默认响应
     *
     * @var Response
     */
    private Response $response;

    /**
     * 初始化
     *
     * @param ContainerInterface $container
     * @param Closure|string $point
     * @param array $args
     * @param int $cacheDuration
     */
    public function __construct(private ContainerInterface $container, private Closure|string $point, private array $args, private int $cacheDuration)
    {
        $this->response = new Response(200, '', ['Server' => 'Chaser/1.0', 'Connection' => 'keep-alive']);
        $this->args['response'] = $this->response;
    }

    /**
     * 处理请求并生成响应
     *
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->args['request'] = $request;

        try {
            $result = $this->container->make($this->point, $this->args);
            return $result instanceof ResponseInterface ? $result : $this->response->withBody(Stream::create((string)$result));
        } catch (NotFoundException | ResolvedException $e) {
            return $this->response->withStatus(500)->withBody(Stream::create(sprintf('[%s-%d] [%s]', $e->getFile(), $e->getLine(), $e->getMessage())));
        }
    }
}
