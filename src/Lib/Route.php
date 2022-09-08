<?php

namespace D3V\Lib;

use D3V\Core\App;
use D3V\Core\CoreController;
use D3V\Exceptions\MethodNotAllowedException;
use D3V\Exceptions\NotFoundException;
use D3V\Util\Debug;

class Route
{
    private string $method;
    private string $path;
    private array $action;
    private array $args;
    private array $params;

    public function __construct($method, $path, $action, $args = [], $params = [])
    {
        $this->method = $method;
        $this->path = $path;
        $this->action = $action;
        $this->args = $args;
        $this->params = $params;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getArgs()
    {
        return $this->args;
    }

    public function getPermissions()
    {
        return $this->params['permissions'] ?? [];
    }

    public function getWriteLog()
    {
        return $this->params['writeLog'] ?? false;
    }

    public function getNeedsAuth()
    {
        return $this->params['needsAuth'] ?? true;
    }

    public function dispatch(App $app)
    {
        list($class, $method) = $this->action;

        if (!is_subclass_of($class, CoreController::class) || !method_exists($class, $method)) {
            throw new NotFoundException();
        }

        if ($this->method !== $_SERVER['REQUEST_METHOD']) {
            throw new MethodNotAllowedException();
        }

        return $app->container->call($this->action, array_merge($this->args, ['route' => $this]));
    }
}
