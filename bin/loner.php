#!/usr/bin/env php
<?php

declare(strict_types=1);

use Loner\Skeleton\Application;

ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');

error_reporting(E_ALL);

// composer 自加载文件
require_once __DIR__ . '/../vendor/autoload.php';

$console = Application::console();

$container = Application::container();

$container->resolveMethod($console, 'run');
