<?php

namespace Mkrawczyk\DbQueryBuilder\Nodes;

class RawSQL extends Node
{
    public string $sql;
    public ?string $dialect;

    public function __construct(string $sql, ?string $dialect = null)
    {
        $this->sql = $sql;
        $this->dialect = $dialect;
    }
}
