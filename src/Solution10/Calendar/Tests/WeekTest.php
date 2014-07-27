<?php

namespace Solution10\Calendar\Tests;

use PHPUnit_Framework_TestCase;
use Solution10\Calendar\Week;
use DateTime;

/**
 * Class WeekTest
 *
 * FOR REFERENCE:
 *
 *  APRIL 2014
 *  | M | T | W | T | F | S | S |
 *  |---|---|---|---|---|---|---|
 *  |   | 1 | 2 | 3 | 4 | 5 | 6 |
 *  | 7 | 8 | 9 |10 |11 |12 |13 |
 *  |14 |15 |16 |17 |18 |19 |20 |
 *  |21 |22 |23 |24 |25 |26 |27 |
 *  |28 |29 |30 |   |   |   |   |
 *
 * @package Solution10\Calendar\Tests
 */
class WeekTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $w = new Week(new DateTime('2014-04-05'));
        $this->assertInstanceOf('Solution10\\Calendar\\Week', $w);
    }

    /*
     * -------------- Week Start tests ------------------
     */

    public function testWeekStartMidweekPoint()
    {
        $w = new Week(new DateTime('2014-04-03'));
        $this->assertEquals('2014-03-31', $w->weekStart()->format('Y-m-d'));
    }

    public function testWeekStartMonday()
    {
        $w = new Week(new DateTime('2014-04-07'));
        $this->assertEquals('2014-04-07', $w->weekStart()->format('Y-m-d'));
    }

    public function testWeekStartYearBoundary()
    {
        $w = new Week(new DateTime('2014-01-02'));
        $this->assertEquals('2013-12-30', $w->weekStart()->format('Y-m-d'));
    }

    /*
     * --------------- Week End tests ------------------
     */

    public function testWeekEndMidweekPoint()
    {
        $w = new Week(new DateTime('2014-04-03'));
        $this->assertEquals('2014-04-06', $w->weekEnd()->format('Y-m-d'));
    }

    public function testWeekEndSunday()
    {
        $w = new Week(new DateTime('2014-04-13'));
        $this->assertEquals('2014-04-13', $w->weekEnd()->format('Y-m-d'));
    }

    public function testWeekEndYearBoundary()
    {
        $w = new Week(new DateTime('2013-12-30'));
        $this->assertEquals('2014-01-05', $w->weekEnd()->format('Y-m-d'));
    }

    /*
     * ---------- Testing non Monday start weeks -------------
     */

    public function testTuesdayStart()
    {
        $w = new Week(new DateTime('2014-04-02'), 'Tuesday');
        $this->assertEquals('2014-04-01', $w->weekStart()->format('Y-m-d'));
        $this->assertEquals('2014-04-07', $w->weekEnd()->format('Y-m-d'));
    }

    public function testWednesdayStart()
    {
        $w = new Week(new DateTime('2014-04-03'), 'Wednesday');
        $this->assertEquals('2014-04-02', $w->weekStart()->format('Y-m-d'));
        $this->assertEquals('2014-04-08', $w->weekEnd()->format('Y-m-d'));
    }

    public function testThursdayStart()
    {
        $w = new Week(new DateTime('2014-04-04'), 'Thursday');
        $this->assertEquals('2014-04-03', $w->weekStart()->format('Y-m-d'));
        $this->assertEquals('2014-04-09', $w->weekEnd()->format('Y-m-d'));
    }

    public function testFridayStart()
    {
        $w = new Week(new DateTime('2014-04-05'), 'Friday');
        $this->assertEquals('2014-04-04', $w->weekStart()->format('Y-m-d'));
        $this->assertEquals('2014-04-10', $w->weekEnd()->format('Y-m-d'));
    }

    public function testSaturdayStart()
    {
        $w = new Week(new DateTime('2014-04-06'), 'Saturday');
        $this->assertEquals('2014-04-05', $w->weekStart()->format('Y-m-d'));
        $this->assertEquals('2014-04-11', $w->weekEnd()->format('Y-m-d'));
    }

    public function testSundayStart()
    {
        $w = new Week(new DateTime('2014-04-07'), 'Sunday');
        $this->assertEquals('2014-04-06', $w->weekStart()->format('Y-m-d'));
        $this->assertEquals('2014-04-12', $w->weekEnd()->format('Y-m-d'));
    }
}
