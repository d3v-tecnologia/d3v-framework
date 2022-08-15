<?php

namespace D3V\Lib;

use D3V\Core\App;
use D3V\Exceptions\NotFoundException;

class Route
{
    private string $method;
    private array $action;
    private array $args;
    private array $permissions;
    private bool $writeLog;

    public function __construct($method, $action, $args = [], $permissions = [], $writeLog = false)
    {
        $this->method = $method;
        $this->action = $action;
        $this->args = $args;
        $this->permissions = $permissions;
        $this->writeLog = $writeLog;
    }

    public function dispatch(App $app)
    {
        list($class, $method) = $this->action;

        if (!is_subclass_of($class, '\D3V\Core\CoreController') || !method_exists($class, $method)) {
            throw new NotFoundException();
        }

        $app->container->call($this->action, $this->args);
    }
}
