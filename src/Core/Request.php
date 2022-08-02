<?php

namespace D3V\Core;

use D3V\Exceptions\MethodNotAllowedException;

class Request
{
    private $queryBag = [];
    private $postBag = [];
    private $serverBag = [];
    private $headerBag = [];
    private $path = "";

    public function __construct()
    {
        $this->queryBag = $_GET ?? [];
        $this->postBag = $_POST ?? [];
        $this->serverBag = $_SERVER ?? [];
        unset($_GET, $_POST, $_SERVER);

        $this->headerBag = getallheaders();
        $this->path = $this->serverBag["PATH_INFO"];
    }

    public function query($var, $defaultValue = "")
    {
        return $this->queryBag[$var] ?? $defaultValue;
    }

    public function post($var, $defaultValue = "")
    {
        return $this->postBag[$var] ?? $defaultValue;
    }

    public function server($var, $defaultValue = "")
    {
        return $this->serverBag[$var] ?? $defaultValue;
    }

    public function header($var, $defaultValue = "")
    {
        return $this->headerBag[$var] ?? $defaultValue;
    }

    public function methodMustBe($method)
    {
        if ($method !== $this->header("REQUEST_METHOD")) {
            throw new MethodNotAllowedException("request must be $method");
        }
    }
}
