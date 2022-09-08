<?php

namespace Progs\CoreManagement;

use D3V\Core\CoreController;

class MenuController extends CoreController
{
    public function index()
    {
        return $this->html(
            $this->twig->render('@CoreManagement/menu/index.twig')
        );
    }

    public function form()
    {
        return $this->html(
            $this->twig->render('@CoreManagement/menu/form.twig')
        );
    }
}
