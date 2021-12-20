<?php

declare(strict_types=1);

namespace Loner\Skeleton\Factory;

use Loner\Config\Config;

class ConfigFactory
{
    public function __invoke(): Config
    {
        return new Config(CONFIG_DIR . DIRECTORY_SEPARATOR . 'config.php', CONFIG_AUTOLOAD_DIR);
    }
}
