<?php

namespace Mkrawczyk\DbQueryBuilder\Serializers;

use Mkrawczyk\DbQueryBuilder\Serializers\Serializer;

class MSSQL extends AbstractSqlSerializer
{

    public function safeColumnName(string $name): string
    {
       return '"' . str_replace('"', '""', $name) . '"';
    }

    public function safeTableName(string $name): string
    {
        return '"' . str_replace('"', '""', $name) . '"';
    }
}
