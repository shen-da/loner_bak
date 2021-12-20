<?php

declare(strict_types=1);

namespace Loner\Skeleton;

use App\Console\DemoCommand;
use Loner\Config\ConfigInterface;
use Loner\Console\Command\CommandInterface;
use Loner\Console\Console;
use Loner\Container\Container;
use Loner\Container\Exception\{ContainerException, DefinedException, NotFoundException};
use Loner\Skeleton\Factory\{ConfigFactory};

/**
 * 应用
 *
 * @package Loner\Skeleton
 *
 * @method static Container container
 * @method static Console console
 */
class Application
{
    /**
     * 应用实例
     *
     * @var self
     */
    private static self $instance;

    /**
     * 数据集
     *
     * @var array
     */
    private static array $dataset = [];

    /**
     * 依赖关系
     *
     * @var array
     */
    private static array $dependencies = [
        ConfigInterface::class => ConfigFactory::class . '::__invoke',
    ];

    /**
     * 静态方法指向引导程序
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments): mixed
    {
        return self::$dataset[$name] ??= self::instance()->{"_{$name}"}(...$arguments);
    }

    /**
     * 获取引导程序
     *
     * @return self
     */
    private static function instance(): self
    {
        return self::$instance ??= new self();
    }

    /**
     * 获取容器实例
     *
     * @return Container
     * @throws ContainerException
     * @throws DefinedException
     * @throws NotFoundException
     */
    protected function _container(): Container
    {
        // 初始化容器并定义默认依赖源
        $container = new Container();
        $container->defineBatch(self::$dependencies);

        /** @var ConfigInterface $config */
        $config = $container->get(ConfigInterface::class);

        // 定义配置依赖源
        $container->defineBatch($config->get('dependencies'));

        return $container;
    }

    /**
     * 获取控制台实例
     *
     * @return Console
     * @throws ContainerException
     * @throws NotFoundException
     */
    protected function _console(): Console
    {
        $container = self::container();

        $console = $container->get(Console::class);

        /** @var CommandInterface[] $commands */
        $commands = [$container->get(DemoCommand::class)];

        // 加载命令
        array_walk($commands, fn($command) => $console->add($command));

        return $console;
    }
}