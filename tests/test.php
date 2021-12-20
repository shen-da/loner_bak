<?php

declare(strict_types=1);

use Loner\Skeleton\Application;

require __DIR__ . '/../vendor/autoload.php';

$container = Application::container();


try {
    var_dump('try');
} catch (Exception $e) {
    var_dump('Exception', get_class($e), $e->getMessage(), $e->getCode());
} catch (Error $e) {
    var_dump('Error', get_class($e), $e->getMessage(), $e->getCode());
} catch (Throwable $e) {
    var_dump(get_class($e), $e->getMessage(), $e->getCode());
}


