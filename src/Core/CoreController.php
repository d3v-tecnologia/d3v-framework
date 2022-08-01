<?php

namespace D3V\Core;

abstract class CoreController
{
    /**
     * @Inject
     * @var \D3V\Core\Config
     */
    protected $config;

    /**
     * @Inject
     * @var \Twig\Environment
     */
    protected $twig;
}