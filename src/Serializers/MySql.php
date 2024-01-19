<?php

namespace Mkrawczyk\DbQueryBuilder\Serializers;

use Mkrawczyk\DbQueryBuilder\Nodes\ColumnName;
use Mkrawczyk\DbQueryBuilder\Nodes\From;
use Mkrawczyk\DbQueryBuilder\Nodes\FromSourceTable;
use Mkrawczyk\DbQueryBuilder\Nodes\RawSQL;
use Mkrawczyk\DbQueryBuilder\Nodes\SelectAll;
use Mkrawczyk\DbQueryBuilder\Nodes\SelectColumn;
use Mkrawczyk\DbQueryBuilder\Nodes\SelectQuery;
use Mkrawczyk\DbQueryBuilder\Serializers\Serializer;
use MKrawczyk\FunQuery\FunQuery;

class MySql extends AbstractSqlSerializer
{
    public function safeColumnName(string $name): string
    {
        return '`' . str_replace('`', '``', $name) . '`';
    }

    public function safeTableName(string $name): string
    {
        return '`' . str_replace('`', '``', $name) . '`';
    }
}
