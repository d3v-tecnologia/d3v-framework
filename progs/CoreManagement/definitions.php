<?php

use D3V\Lib\Route;
use Progs\CoreManagement\EstablishmentController;
use Progs\CoreManagement\MenuController;

return [
    "name" => "Gerenciamento Central",
    "description" => "Parametrização de funções centrais do sistema como acesso, menus e mais.",
    "permissions" => [],
    "routes" => [
        //Fiscal Establishments
        new Route('GET', '/core/establishments', [EstablishmentController::class, 'list']),
        new Route('GET', '/core/establishments/form', [EstablishmentController::class, 'form']),

        //Menu
        new Route('GET', '/core/menu', [MenuController::class, 'index']),
        new Route('GET', '/core/menu/form', [MenuController::class, 'form']),
    ],
];
