<?php

use D3V\Lib\Route;

return [
    '/progs/example' => new Route('GET', [\Progs\Example\Controller::class, 'index']),
];
