<?php

namespace Progs\Example;

use D3V\Core\CoreController;
use Progs\Example\Queries\Afiliates;
use Progs\Example\Queries\Members;

class Controller extends CoreController
{
    public function index(Members $members, Afiliates $afiliates)
    {
        try {
            $members = $members->all();
            $afiliates = $afiliates->all();
        } catch (\Exception $err) {
        }
        echo $this->twig->render('@Example/templates/example.twig', [
            'members' => $members,
            'afiliates' => $afiliates,
        ]);
    }
}
