<?php

declare(strict_types=1);

namespace Loner\Config;

use Loner\Utils\Arr;

/**
 * 配置
 *
 * @package Loner\Config
 */
class Config implements ConfigInterface
{
    /**
     * 数据集
     *
     * @var array
     */
    private array $dataset;

    /**
     * 初始化配置
     *
     * @param string $profile 主配置文件
     * @param string|null $autoload 扩展目录
     */
    public function __construct(string $profile, string $autoload = null)
    {
        $this->dataset = require_once $profile . '';

        if ($autoload !== null) {
            $this->autoload($autoload);
        }
    }

    /**
     * @inheritDoc
     */
    public function get(?string $keys = null, mixed $default = null): mixed
    {
        return $keys === null ? $this->dataset : Arr::get($this->dataset, $keys, $default);
    }

    /**
     * 加载扩展目录配置
     *
     * @param string $autoload
     */
    private function autoload(string $autoload): void
    {
        $prefix = $autoload . DIRECTORY_SEPARATOR;
        $len = strlen($prefix);

        foreach (glob($prefix . '*.php') as $path) {
            $filename = substr($path, $len, -4);
            Arr::set($this->dataset, $filename, []);
            foreach (require $path . '' as $name => $value) {
                Arr::set($this->dataset, $filename . '.' . $name, $value);
            }
        }
    }
}
