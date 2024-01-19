<?php

namespace Mkrawczyk\DbQueryBuilder\Serializers;

use Mkrawczyk\DbQueryBuilder\Nodes\ColumnName;
use Mkrawczyk\DbQueryBuilder\Nodes\From;
use Mkrawczyk\DbQueryBuilder\Nodes\FromSourceTable;
use Mkrawczyk\DbQueryBuilder\Nodes\RawSQL;
use Mkrawczyk\DbQueryBuilder\Nodes\SelectAll;
use Mkrawczyk\DbQueryBuilder\Nodes\SelectExpression;
use Mkrawczyk\DbQueryBuilder\Nodes\SelectQuery;
use MKrawczyk\FunQuery\FunQuery;

abstract class AbstractSqlSerializer extends Serializer
{

    public function serialize($node): string
    {
        if ($node instanceof SelectQuery) {
            $ret = 'SELECT ';
            if (empty($node->selectExpressions))
                throw new \Exception('No columns selected');
            $ret .= implode(', ', FunQuery::create($node->selectExpressions)->map(fn($x) => $this->serialize($x))->toArray());

            if (!empty($node->from)) {
                $ret .= ' FROM ';
                $ret .= implode(', ', FunQuery::create($node->from)->map(fn($x) => $this->serialize($x))->toArray());
            }
            if (!empty($node->where)) {
                $ret .= ' WHERE ';
                $ret .= implode(' AND ', FunQuery::create($node->where)->map(fn($x) => $this->serialize($x))->toArray());
            }
            return $ret;
        } else if ($node instanceof SelectAll) {
            return '*';
        } else if ($node instanceof From) {
            return $this->serialize($node->source).($node->alias ? $node->alias : '');

        } else if ($node instanceof FromSourceTable) {
            return $this->safeTableName($node->tableName);
        } else if ($node instanceof SelectExpression) {
            return $this->serialize($node->column).($node->alias ? ' as \''.$node->alias.'\'' : '');
        } else if ($node instanceof ColumnName) {
            return $this->safeColumnName($node->name);
        } else if ($node instanceof RawSQL) {
            return '('.$node->sql.')';
        } else {
            throw new \Exception('Unknown type');
        }
    }
    public abstract function safeColumnName(string $name): string;
    public abstract function safeTableName(string $name): string;

}
