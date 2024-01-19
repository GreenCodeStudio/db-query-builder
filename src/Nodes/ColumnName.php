<?php

namespace Mkrawczyk\DbQueryBuilder\Nodes;

class ColumnName extends Node
{
    public string $name;
    public ?string $table = null;

    public function __construct(string $name, ?string $table = null)
    {
        $this->name = $name;
        $this->table = $table;
    }
}
