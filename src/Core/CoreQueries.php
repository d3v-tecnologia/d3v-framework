<?php

namespace D3V\Core;

abstract class CoreQueries
{
    /**
     * @Inject
     * @var \D3V\Core\DBManager
     */
    protected $dbManager;

    /**
     * @Inject
     * @var \PDO
     */
    protected $default;
}
