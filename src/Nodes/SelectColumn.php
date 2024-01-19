<?php

namespace Mkrawczyk\DbQueryBuilder\Nodes;

class SelectColumn extends Node
{
    public SelectQuery|ColumnName|RawSQL|SelectAll $column;
    public ?string $alias = null;

    public function __construct(SelectQuery|ColumnName|RawSQL|SelectAll $column, ?string $alias = null)
    {
        $this->column = $column;
        $this->alias = $alias;
    }
}
