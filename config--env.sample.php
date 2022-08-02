<?php

return [
    'homepage' => '\\Progs\\Homepage\\HomepageController::index',
    "twig" => [
        "debug" => true,
        "charset" => "utf-8",
        "cache" => __DIR__ . "/cache/twig",
        "auto_reload" => true,
        "strict_variables" => false,
        "autoescape" => false,
        "optimizations" => -1,
    ],
    'default_db_connection' => 'connection1',
    'pdo' => [
        'connection1' => [
            'dsn' => 'driver:host=localhost;dbname=db;port=3306;charset=utf8mb4',
            'username' => 'username',
            'password' => 'password',
            'options' => [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ],
        ],
        'connection2' => [
            'dsn' => 'driver:host=localhost;dbname=db;port=3306;charset=utf8mb4',
            'username' => 'username',
            'password' => 'password',
            'options' => [],
        ],
    ],
    'auth' => [
        'default' => [
            'user_class' => '\\Progs\\UserManagement\\User',
            'forbidden_redirect' => false,
        ]
    ]
];
