<?php

$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('Bernard\\Benchmarks\\', __DIR__);
$loader->add('Bernard\\Tests\\', __DIR__ . '/../tests');
$loader->register();
