<?php

namespace D3V\Core;

use D3V\Util\Debug;

abstract class CoreController
{
    /**
     * @Inject
     * @var \Twig\Environment
     */
    protected $twig;

    /**
     * @Inject
     * @var \D3V\Core\App
     */
    protected $app;

    /**
     * @Inject
     * @var \D3V\Core\AuthManager
     */
    protected $auth;

    protected function requiresAuth($provider)
    {
        $user = $this->auth->get($provider);

        if (!$user) {
            return $this->auth->unauthorized($provider);
        }

        return $user;
    }
}
