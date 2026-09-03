<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

foreach (glob(__DIR__ . '/config/*.php') as $file) {

    try {

        $value = require $file;

        echo basename($file)
            . ' => '
            . gettype($value)
            . PHP_EOL;

    } catch (Throwable $e) {

        echo basename($file)
            . ' => ERROR: '
            . $e->getMessage()
            . PHP_EOL;
    }
}
