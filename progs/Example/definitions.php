<?php

use D3V\Lib\Permission;
use D3V\Lib\Route;

return [
    "name" => "Programa de exemplo",
    "description" => "Programa desenvolvido para testar as coisas novas do D3V Framework",
    "permissions" => [
        new Permission('Example::listar_membros', 'Lista de membros', 'Permissão de acesso a lista de membros'),
        new Permission('Example::cadastrar_membros', 'Cadastrar membros', 'Permissão de cadastro de membros'),
    ],
    "routes" => [
        new Route('GET', '/progs/example', [\Progs\Example\Controller::class, 'index']),
    ],
];
