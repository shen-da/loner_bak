<?php

declare(strict_types=1);

namespace Loner\Utils;

use ArrayAccess;
use Closure;

/**
 * 数组工具类
 *
 * @package Loner\Utils
 */
class Arr
{
    /**
     * 获取数据
     *
     * @param array $dataset
     * @param string $keys
     * @param mixed $default
     * @return mixed
     */
    public static function get(array $dataset, string $keys, mixed $default = null): mixed
    {
        $key = (string)strtok($keys, '.');

        do {
            if (!self::accessible($dataset) || !isset($dataset[$key])) {
                return $default instanceof Closure ? $default() : $default;
            }
            $dataset = $dataset[$key];
        } while (false !== $key = strtok('.'));

        return $dataset;
    }

    /**
     * 设置数据
     *
     * @param array $dataset
     * @param string $keys
     * @param mixed $value
     */
    public static function set(array &$dataset, string $keys, mixed $value): void
    {
        $keys = explode('.', $keys);

        while (count($keys) > 1) {
            $key = array_shift($keys);
            if (!isset($dataset[$key]) || !self::accessible($dataset[$key])) {
                $dataset[$key] = [];
            }
            $dataset = &$dataset[$key];
        }

        $dataset[array_shift($keys)] = $value;
    }

    /**
     * 删除数据
     *
     * @param array $dataset
     * @param string $keys
     */
    public static function unset(array &$dataset, string $keys): void
    {
        $keys = explode('.', $keys);

        while (count($keys) > 1) {
            $key = array_shift($keys);
            if (!isset($dataset[$key]) || !self::accessible($dataset[$key])) {
                return;
            }
            $dataset = &$dataset[$key];
        }
        unset($dataset[array_shift($keys)]);
    }

    /**
     * 判断给定数据是否可以数组形式访问
     *
     * @param mixed $data
     * @return bool
     */
    public static function accessible(mixed $data): bool
    {
        return is_array($data) || $data instanceof ArrayAccess;
    }
}
