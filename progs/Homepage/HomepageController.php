<?php

namespace Progs\Homepage;

use D3V\Core\CoreController;

class HomepageController extends CoreController
{
    public function index()
    {
        echo $this->twig->render('@Homepage/templates/index.twig');
    }
}
