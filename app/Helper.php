<?php

declare(strict_types=1);

namespace app;

use Closure;

class Helper
{
    /**
     *
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function env(string $key, mixed $default = null): mixed
    {
        $value = getenv($key);
        if ($value === false) {
            return Helper::value($default);
        }
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }
        $length = strlen($value);
        return $length > 1 && $value[0] === '"' && $value[$length - 1] === '"'
            ? substr($value, 1, -1)
            : $value;
    }

    /**
     * 返回给定默认值，若是闭包，返回无参执行结果
     *
     * @param mixed $value
     * @return mixed
     */
    public function value(mixed $value): mixed
    {
        return $value instanceof Closure ? $value() : $value;
    }
}
