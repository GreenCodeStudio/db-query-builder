<?php


use PHPUnit\Framework\TestCase;

class SelectQueryTest extends TestCase
{
    public function testBasicSelectQuery()
    {
        $obj=new \Mkrawczyk\DbQueryBuilder\Nodes\SelectQuery();
        $obj->selectAll();
        $obj->from('example');

        $this->assertEquals('SELECT * FROM example', $obj->getSql('MySQL'));
        $this->assertEquals('SELECT * FROM example', $obj->getSql('MSSQL'));
    }
    public function testBasicSelectQueryNoTable()
    {
        $obj=new \Mkrawczyk\DbQueryBuilder\Nodes\SelectQuery();
        $obj->select('2+2', 'four');
        $obj->select('3+3', 'six');

        $this->assertEquals('SELECT 2+2 as four, 3+3 as six', $obj->getSql('MySQL'));
        $this->assertEquals('SELECT 2+2 as four, 3+3 as six', $obj->getSql('MSSQL'));
    }
    public function testNormalSelectQuery()
    {
        $obj=new \Mkrawczyk\DbQueryBuilder\Nodes\SelectQuery();
        $obj->selectAll();
        $obj->from('example');
        $obj->where('column1 < 5');
        $obj->where('column2 IS NULL');
        $this->assertEquals('SELECT * FROM example WHERE (column1 < 5) AND (column2 IS NULL)', $obj->getSql('MySQL'));
        $this->assertEquals('SELECT * FROM example WHERE (column1 < 5) AND (column2 IS NULL)', $obj->getSql('MSSQL'));
    }
}
