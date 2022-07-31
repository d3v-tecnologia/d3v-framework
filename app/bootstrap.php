<?php

use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder;
$containerBuilder->useAnnotations(true);
$container = $containerBuilder->build();

return $container;
