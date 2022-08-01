<?php

namespace Progs\Example;

use D3V\Core\CoreController;

class Controller extends CoreController
{
    public function index()
    {
        echo $this->twig->render('@Example/templates/example.twig');
    }
}
