<?php

namespace Nodes;

use Mkrawczyk\DbQueryBuilder\Nodes\RawSQL;
use PHPUnit\Framework\TestCase;

class RawSQLTest extends TestCase
{
    public function testToSQL()
    {
        $dumbString = "sdfsdfsd";
        $rawSQL = new RawSQL($dumbString);
        $this->assertEquals('('.$dumbString.')', $rawSQL->getSql("MySQL"));
    }
}
