<?php

namespace Progs\Example\Queries;

use D3V\Core\CoreQueries;

class Members extends CoreQueries
{
    public function all()
    {
        $stmt = $this->default->prepare("SELECT * FROM members LIMIT 0, 10");
        $stmt->execute();
        return $stmt;
    }
}
