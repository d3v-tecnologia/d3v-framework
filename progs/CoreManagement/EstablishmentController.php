<?php

namespace Progs\CoreManagement;

use D3V\Core\CoreController;

class EstablishmentController extends CoreController
{
    public function list()
    {
        return $this->html(
            $this->twig->render('@CoreManagement/establishment/list.twig')
        );
    }

    public function form()
    {
        return $this->html(
            $this->twig->render('@CoreManagement/establishment/form.twig')
        );
    }
}
