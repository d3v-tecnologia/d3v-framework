<?php

$container = require __DIR__ . '/../app/bootstrap.php';

$container->call('Progs\Example\Controller::index');
