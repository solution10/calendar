<?php

namespace Solution10\Calendar\Tests;

use PHPUnit_Framework_TestCase;
use Solution10\Calendar\Year;

class YearTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $y = new Year(2014);
        $this->assertInstanceOf('Solution10\\Calendar\\Year', $y);
    }

    /**
     * @expectedException       \Solution10\Calendar\Exception\Date
     * @expectedExceptionCode   \Solution10\Calendar\Exception\Date::INVALID_DATE
     */
    public function testConstructBadYear()
    {
        new Year('apple');
    }

    public function testYearFullFunction()
    {
        $y = new Year(2014);
        $this->assertEquals(2014, $y->yearFull());
    }

    public function testYearShortFunction()
    {
        $y = new Year(2014);
        $this->assertEquals(14, $y->yearShort());
    }

    public function testIsLeapYear()
    {
        $y = new Year(2014);
        $this->assertFalse($y->isLeapYear());

        $y = new Year(2012);
        $this->assertTrue($y->isLeapYear());
    }
}
