<?php

// echo "<pre>" . print_r($_SERVER, true) . "</pre>";
// echo "<pre>" . print_r(getallheaders(), true) . "</pre>";

$app = require __DIR__ . '/../app/bootstrap.php';

$app->dispatch();
