<?php

namespace Progs\Example;

use D3V\Core\CoreController;

class Controller extends CoreController
{
    public function index()
    {
        var_dump($this->config->need('key'));
    }
}
