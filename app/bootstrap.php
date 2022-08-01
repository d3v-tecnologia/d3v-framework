<?php

use D3V\Core\App;

require __DIR__ . '/../vendor/autoload.php';

$app = new App();
$app->bootstrap();

return $app;
