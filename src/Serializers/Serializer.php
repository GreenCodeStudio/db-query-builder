<?php

namespace Mkrawczyk\DbQueryBuilder\Serializers;

abstract class Serializer
{

    public static function get(string $type)
    {
        if ($type == 'MySQL') {
            return new MySql();
        } else if ($type == 'MSSQL') {
            return new MSSQL();
        } else {
            throw new \Exception('Unknown type');
        }
    }
}
