<?php

namespace D3V\Core;

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
}
