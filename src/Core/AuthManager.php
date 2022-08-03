<?php

namespace D3V\Core;

use D3V\Exceptions\UnauthorizedException;
use D3V\Interfaces\Authenticatable;
use D3V\Util\Debug;

class AuthManager
{
    private static array $bag;
    private array $config;

    public function __construct(Config $config)
    {
        $this->config = $config->get('auth', []);
    }

    public function get(string $provider): Authenticatable | null
    {
        if (!isset(self::$bag[$provider])) {
            $cfg = $this->config[$provider] ?? null;
            if (!$cfg) {
                return null;
            }
            self::$bag[$provider] = $cfg['user_class']::loadFromRequest();
        }
        return self::$bag[$provider] ?? null;
    }

    public function unauthorized($provider)
    {
        $route = $this->config[$provider]['unauthorized_redirect'] ?? "";
        if (empty($route)) {
            throw new UnauthorizedException();
        }

        header("Location: $route");
    }
}
