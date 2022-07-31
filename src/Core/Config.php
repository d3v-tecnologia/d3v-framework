<?php

namespace D3V\Core;

class Config
{
    private $bag = [];

    public function __construct()
    {
        $this->bag = require("../config--" . getenv("D3V_ENV") . ".php");
    }

    public function check($key)
    {
        return !empty($this->bag[$key]);
    }

    public function get($key, $defaultValue = "")
    {
        return $this->bag[$key] ?? $defaultValue;
    }

    public function need($key)
    {
        if (!$this->check($key)) {
            throw new ConfigNotFoundException("config key was not found: $key");
        }
        return $this->bag[$key];
    }
}

class ConfigNotFoundException extends \Exception
{
}
