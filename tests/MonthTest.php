<?php

namespace Solution10\Calendar\Tests;

use PHPUnit_Framework_TestCase;
use Solution10\Calendar\Month;
use DateTime;

class MonthTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $m = new Month(new DateTime('2014-04-16'));
        $this->assertInstanceOf('Solution10\\Calendar\\Month', $m);
    }

    public function testTitle()
    {
        $m = new Month(new DateTime('2014-04-16'));
        $this->assertEquals('2014-04-01', $m->title('Y-m-d'));
    }

    /*
     * -------------- Testing Start and End dates --------------
     */

    public function testFirstDay()
    {
        $m = new Month(new DateTime('2014-04-16'));
        $this->assertEquals('2014-04-01', $m->firstDay()->format('Y-m-d'));
    }

    public function testLastDay()
    {
        $m = new Month(new DateTime('2014-04-16'));
        $this->assertEquals('2014-04-30', $m->lastDay()->format('Y-m-d'));
    }

    /*
     * --------------- Test number of days -------------------
     */

    public function testNumDays()
    {
        $m = new Month(new DateTime('2014-04-16'));
        $this->assertEquals(30, $m->numDays());

        $m = new Month(new DateTime('2014-05-27'));
        $this->assertEquals(31, $m->numDays());
    }

    /*
     * ----------------- Test Year Accessor -------------------
     */

    public function testYear()
    {
        $m = new Month(new DateTime('2014-04-16'));
        $this->assertInstanceOf('Solution10\\Calendar\\Year', $m->year());
        $this->assertEquals(2014, $m->year()->yearFull());
    }

    /*
     * --------------- Testing Weeks Access ----------------
     */

    public function testWeeks()
    {
        $april = new Month(new DateTime('2014-04-16'));
        $this->assertTrue(is_array($april->weeks()));
        $this->assertCount(5, $april->weeks());

        $may = new Month(new DateTime('2014-05-27'));
        $this->assertTrue(is_array($may->weeks()));
        $this->assertCount(5, $may->weeks());

        $june = new Month(new DateTime('2014-06-08'));
        $this->assertTrue(is_array($june->weeks()));
        $this->assertCount(6, $june->weeks());
    }

    /*
     * ------------ Testing Timeframe ------------------
     */

    public function testTimeframeImplementation()
    {
        $m = new Month(new DateTime('2014-04-16'));
        $this->assertEquals('2014-04-01 00:00:00', $m->start()->format('Y-m-d H:i:s'));
        $this->assertEquals('2014-04-30 23:59:59', $m->end()->format('Y-m-d H:i:s'));
    }
}
