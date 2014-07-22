<?php

namespace Solution10\Calendar\Tests;

use PHPUnit_Framework_TestCase;
use Solution10\Calendar\Cell;

class CellTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $c = new Cell();
        $this->assertInstanceOf('Solution10\\Calendar\\Cell', $c);

        $c = new Cell(array(
            'day' => false,
            'month' => 7,
            'year' => 2014
        ));
        $this->assertInstanceOf('Solution10\\Calendar\\Cell', $c);

        $c = new Cell(array(
            'day' => false,
            'month' => false,
            'year' => 2014
        ), true);
        $this->assertInstanceOf('Solution10\\Calendar\\Cell', $c);
    }

    public function testSetGetFullCellDate()
    {
        $c = new Cell(array());
        $c->setCellDate(array(
            'day' => 2,
            'month' => 7,
            'year' => 1988
        ));

        $this->assertEquals(2, $c->getDay());
        $this->assertEquals(7, $c->getMonth());
        $this->assertEquals(1988, $c->getYear());
    }

    public function testSetGetAllFalseCellDate()
    {
        $c = new Cell(array());
        $c->setCellDate(array(
                'day' => false,
                'month' => false,
                'year' => false
            ));

        $this->assertFalse($c->getDay());
        $this->assertFalse($c->getMonth());
        $this->assertFalse($c->getYear());
    }

    public function testSetCellDateCasting()
    {
        $c = new Cell(array());
        $c->setCellDate(array(
                'day' => '2',
                'month' => '7.567',
                'year' => '1988'
            ));

        $this->assertEquals(2, $c->getDay());
        $this->assertEquals(7, $c->getMonth());
        $this->assertEquals(1988, $c->getYear());
    }

    public function testConstructorIsOverflow()
    {
        $c = new Cell();
        $this->assertFalse($c->isOverflow());

        $c = new Cell(array(), true);
        $this->assertTrue($c->isOverflow());
    }

    public function testSetGetIsOverflow()
    {
        $c = new Cell();
        $this->assertFalse($c->isOverflow());

        $c->setIsOverflow(true);
        $this->assertTrue($c->isOverflow());
    }
}
