<?php

namespace Solution10\Calendar\Tests;

use PHPUnit_Framework_TestCase;
use Solution10\Calendar\Month;

class MonthTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $m = new Month(2014, 4);
        $this->assertInstanceOf('Solution10\\Calendar\\Month', $m);
    }

    /**
     * @expectedException       \Solution10\Calendar\Exception\Date
     * @expectedExceptionCode   \Solution10\Calendar\Exception\Date::INVALID_DATE
     */
    public function testConstructBadYear()
    {
        new Month('apple', 4);
    }

    /**
     * @expectedException       \Solution10\Calendar\Exception\Date
     * @expectedExceptionCode   \Solution10\Calendar\Exception\Date::INVALID_DATE
     */
    public function testConstructBadMonth()
    {
        new Month(2014, 'apple');
    }

    /*
     * -------------- Testing Start and End dates --------------
     */

    public function testFirstDay()
    {
        $m = new Month(2014, 4);
        $this->assertEquals('2014-04-01', $m->firstDay()->format('Y-m-d'));
    }

    public function testLastDay()
    {
        $m = new Month(2014, 4);
        $this->assertEquals('2014-04-30', $m->lastDay()->format('Y-m-d'));
    }

    /*
     * --------------- Test number of days -------------------
     */

    public function testNumDays()
    {
        $m = new Month(2014, 4);
        $this->assertEquals(30, $m->numDays());

        $m = new Month(2014, 5);
        $this->assertEquals(31, $m->numDays());
    }

    /*
     * ----------------- Test Year Accessor -------------------
     */

    public function testYear()
    {
        $m = new Month(2014, 4);
        $this->assertInstanceOf('Solution10\\Calendar\\Year', $m->year());
        $this->assertEquals(2014, $m->year()->yearFull());
    }
}
