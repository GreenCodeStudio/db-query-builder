<?php

namespace Mkrawczyk\DbQueryBuilder\Nodes;

use Exception;
use Mkrawczyk\DbQueryBuilder\Serializers\Serializer;

class SelectQuery extends Node
{
    public array $selectExpressions = [];
    public array $from = [];
    public array $where = [];

    public function selectAll()
    {
        $this->selectExpressions[] = new SelectAll();
    }

    public function from(SelectQuery|FromSourceTable|RawSQL $source, ?string $alias = null)
    {
        $this->from[] = new From($source, $alias);
    }


    public function select(SelectQuery|ColumnName|RawSQL $column, ?string $alias = null)
    {
        $this->selectExpressions[] = new SelectExpression($column, $alias);
    }

    public function selectColumn(string $column, ?string $alias = null)
    {
        if ($this->hasAnyOfChars($column, '\'".[]()')) {
            throw new Exception('Invalid column name');
        }
        $column = new ColumnName($column);

        $this->selectExpressions[] = new SelectExpression($column, $alias);
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

    public function limit(?int $limit=null)
    {
        $this->limit = $limit;
    }
    public function offset(?int $offset=null)
    {
        $this->offset = $offset;
    }

    /**
     * @alias offset
     */
    public function top(?int $top=null)
    {
        $this->offset($top);
    }

    public function setDistinct(bool $value=true)
    {
        $this->distinct = $value;
    }
}
