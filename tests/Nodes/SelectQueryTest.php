<?php


namespace Nodes;

use Mkrawczyk\DbQueryBuilder\Nodes\RawSQL;
use PHPUnit\Framework\TestCase;

class SelectQueryTest extends TestCase
{
    public function testEmptySelectQueryMySql()
    {
        $obj = new \Mkrawczyk\DbQueryBuilder\Nodes\SelectQuery();
        $this->expectException(\Exception::class);
        $obj->getSql('MySQL');
    }
    public function testEmptySelectQueryMSSQL()
    {
        $obj = new \Mkrawczyk\DbQueryBuilder\Nodes\SelectQuery();
        $this->expectException(\Exception::class);
        $obj->getSql('MSSQL');
    }

    public function testBad1FromSelectQuery()
    {
        $obj = new \Mkrawczyk\DbQueryBuilder\Nodes\SelectQuery();

        $this->expectException(\Exception::class);
        $obj->fromTable('(SELECT * FROM tab2)');
    }
    public function testBad2FromSelectQuery()
    {
        $obj = new \Mkrawczyk\DbQueryBuilder\Nodes\SelectQuery();

        $this->expectException(\Exception::class);
        $obj->fromTable('db.table');
    }

    public function testBasicSelectQuery()
    {
        $obj = new \Mkrawczyk\DbQueryBuilder\Nodes\SelectQuery();
        $obj->selectAll();
        $obj->fromTable('example');

        $this->assertEquals('SELECT * FROM `example`', $obj->getSql('MySQL'));
        $this->assertEquals('SELECT * FROM "example"', $obj->getSql('MSSQL'));
    }

    public function testBasicSelectColumnsQuery()
    {
        $obj = new \Mkrawczyk\DbQueryBuilder\Nodes\SelectQuery();
        $obj->selectColumn('column1');
        $obj->selectColumn('column2', 'col2');
        $obj->fromTable('example');

        $this->assertEquals('SELECT `column1`, `column2` as \'col2\' FROM `example`', $obj->getSql('MySQL'));
        $this->assertEquals('SELECT "column1", "column2" as \'col2\' FROM "example"', $obj->getSql('MSSQL'));
    }

    public function testBasicSelectQueryNoTable()
    {
        $obj = new \Mkrawczyk\DbQueryBuilder\Nodes\SelectQuery();
        $obj->select(new RawSQL('2+2'), 'four');
        $obj->select(new RawSQL('3+3'), 'six');

        $this->assertEquals('SELECT (2+2) as \'four\', (3+3) as \'six\'', $obj->getSql('MySQL'));
        $this->assertEquals('SELECT (2+2) as \'four\', (3+3) as \'six\'', $obj->getSql('MSSQL'));
    }

    public function testNormalSelectQuery()
    {
        $obj = new \Mkrawczyk\DbQueryBuilder\Nodes\SelectQuery();
        $obj->selectAll();
        $obj->fromTable('example');
        $obj->where(new RawSQL('column1 < 5'));
        $obj->where(new RawSQL('column2 IS NULL'));
        $this->assertEquals('SELECT * FROM `example` WHERE (column1 < 5) AND (column2 IS NULL)', $obj->getSql('MySQL'));
        $this->assertEquals('SELECT * FROM "example" WHERE (column1 < 5) AND (column2 IS NULL)', $obj->getSql('MSSQL'));
    }
    public function testFullSelectQuery()
    {
        $obj = new \Mkrawczyk\DbQueryBuilder\Nodes\SelectQuery();
        $obj->setDistinct();
        $obj->selectAll();
        $obj->selectColumn('column2', 'col2');
        $obj->select(new RawSQL('2+2'), 'four');
        $obj->fromTable('example');
        $obj->where(new RawSQL('1<2'));
        $obj->orderBy(new RawSQL('column2'));
        $obj->orderByColumnDesc('column1');
        $obj->limit(10);
        $obj->offset(5);
        $this->assertEquals('SELECT DISTINCT *, `column2` as \'col2\', (2+2) as \'four\' FROM `example` WHERE (1 < 2) ORDER BY (coluimn2), column1 DESC OFFSET 5 LIMIT 10', $obj->getSql('MySQL'));
        $this->assertEquals('SELECT DISTINCT *, "column2" as \'col2\', (2+2) as \'four\' FROM "example" WHERE (1 < 2) ORDER BY (coluimn2), column1 DESC OFFSET 5 ROWS FETCH NEXT 10 ROWS ONLY', $obj->getSql('MSSQL'));
    }
}
