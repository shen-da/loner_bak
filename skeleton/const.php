<?php

declare(strict_types=1);

// 项目目录
define('ROOT_DIR', dirname(__DIR__));

// 应用目录
define('APP_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'app');
define('CONSOLE_DIR', APP_DIR . DIRECTORY_SEPARATOR . 'console');
define('HTTP_DIR', APP_DIR . DIRECTORY_SEPARATOR . 'http');
define('CONTROLLER_DIR', HTTP_DIR . DIRECTORY_SEPARATOR . 'controller');

// 引导目录
define('BOOTSTRAP_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'bootstrap');

// 框架目录、文件
define('SKELETON_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'skeleton');
define('PID_FILE', SKELETON_DIR . DIRECTORY_SEPARATOR . 'skeleton.pid');

// 配置目录、文件
define('CONFIG_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'config');
define('CONFIG_AUTOLOAD_DIR', CONFIG_DIR . DIRECTORY_SEPARATOR . 'autoload');
define('CONFIG_SKELETON_DIR', CONFIG_DIR . DIRECTORY_SEPARATOR . 'skeleton');
define('SKELETON_PROFILE', CONFIG_SKELETON_DIR . DIRECTORY_SEPARATOR . 'master.php');

// 缓存目录
define('STORAGE_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'storage');

// 公共目录
define('PUBLIC_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'public');
