<?php

namespace Mkrawczyk\DbQueryBuilder\Nodes;

use Exception;
use Mkrawczyk\DbQueryBuilder\Serializers\Serializer;

class SelectQuery extends Node
{
    public array $selectColumns = [];
    public array $from = [];
    public array $where = [];

    public function selectAll()
    {
        $this->selectColumns[] = new SelectAll();
    }

    public function from(SelectQuery|FromSourceTable|RawSQL $source, ?string $alias = null)
    {
        $this->from[] = new From($source, $alias);
    }


    public function select(SelectQuery|ColumnName|RawSQL $column, ?string $alias = null)
    {
        $this->selectColumns[] = new SelectColumn($column, $alias);
    }

    public function selectColumn(string $column, ?string $alias = null)
    {
        if ($this->hasAnyOfChars($column, '\'".[]()')) {
            throw new Exception('Invalid column name');
        }
        $column = new ColumnName($column);

        $this->selectColumns[] = new SelectColumn($column, $alias);
    }

    public function fromTable(string $source, ?string $alias = null)
    {
        if ($this->hasAnyOfChars($source, '\'".[]()')) {
            throw new Exception('Invalid table name');
        }
        $source = new FromSourceTable($source);
        $this->from($source, $alias);

    }

    public function where(RawSQL $condition)
    {
        $this->where[] = $condition;
    }
}
