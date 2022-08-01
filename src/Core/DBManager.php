<?php

namespace D3V\Core;

class DBManager
{
    private $bag = [];
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function connect($connectionName)
    {
        $cfg =  $this->config[$connectionName];
        $pdo = new \PDO($cfg['dsn'], $cfg['username'], $cfg['password'], $cfg['options']);
        $this->bag[$connectionName] = $pdo;
        return $pdo;
    }

    public function get($connectionName)
    {
        if (empty($this->bag[$connectionName])) {
            $this->connect($connectionName);
        }
        return $this->bag[$connectionName];
    }
}
