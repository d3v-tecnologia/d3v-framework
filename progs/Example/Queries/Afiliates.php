<?php

namespace Progs\Example\Queries;

use D3V\Core\CoreQueries;

class Afiliates extends CoreQueries
{
    public function all()
    {
        $stmt = $this->dbManager->get('rede-e')->prepare("SELECT * FROM afiliados ORDER BY id OFFSET 0 LIMIT 10");
        $stmt->execute();
        return $stmt;
    }
}
