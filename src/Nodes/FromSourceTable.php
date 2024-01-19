<?php

namespace Mkrawczyk\DbQueryBuilder\Nodes;

class FromSourceTable extends Node
{
    public string $tableName;

    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
    }
}
