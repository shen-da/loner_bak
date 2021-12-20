<?php

declare(strict_types=1);

namespace Loner\Log;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Stringable;

/**
 * 记录器
 *
 * @package Loner\Log
 */
class Logger implements LoggerInterface
{
    use LoggerTrait;

    /**
     * @inheritDoc
     */
    public function log($level, Stringable|string $message, array $context = []): void
    {
        // TODO: Implement log() method.
    }
}
