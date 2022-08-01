<?php

$app = require __DIR__ . '/../app/bootstrap.php';

$app->container->call('Progs\Example\Controller::index');
