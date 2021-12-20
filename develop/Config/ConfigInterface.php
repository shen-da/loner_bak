<?php

declare(strict_types=1);

namespace Loner\Config;

/**
 * 配置
 *
 * @package Loner\Config
 */
interface ConfigInterface
{
    /**
     * 获取配置
     *
     * @param string|null $keys 通过“.”连缀实现递归查询
     * @param mixed $default 默认值，若是闭包会返回执行结果
     * @return mixed
     */
    public function get(?string $keys = null, mixed $default = null): mixed;
}
