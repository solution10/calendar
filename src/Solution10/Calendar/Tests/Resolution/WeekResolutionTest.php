<?php

namespace Solution10\Calendar\Tests\Resolution;

use PHPUnit_Framework_TestCase;
use Solution10\Calendar\Resolution\WeekResolution as WeekResolution;
use DateTime;

/**
 * Class WeekResolutionTest
 *
 * Tests out the Week resolution on the calendar.
 *
 * FOR REFERENCE: Apr-May-June 2014:
 *
 *  APRIL                           MAY                             JUNE
 *  | M | T | W | T | F | S | S | : | M | T | W | T | F | S | S | : | M | T | W | T | F | S | S |
 *  |---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|
 *  |   | 1 | 2 | 3 | 4 | 5 | 6 |   |   |   |   | 1 | 2 | 3 | 4 |   |   |   |   |   |   |   | 1 |
 *  | 7 | 8 | 9 |10 |11 |12 |13 |   | 5 | 6 | 7 | 8 | 9 |10 |11 |   | 2 | 3 | 4 | 5 | 6 | 7 | 8 |
 *  |14 |15 |16 |17 |18 |19 |20 |   |12 |13 |14 |15 |16 |17 |18 |   | 9 |10 |11 |12 |13 |14 |15 |
 *  |21 |22 |23 |24 |25 |26 |27 |   |19 |20 |21 |22 |23 |24 |25 |   |16 |17 |18 |19 |20 |21 |22 |
 *  |28 |29 |30 |   |   |   |   |   |26 |27 |28 |29 |30 |31 |   |   |23 |24 |25 |26 |27 |28 |29 |
 *  |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |30 |   |   |   |   |   |   |
 *
 * @package Solution10\Calendar\Tests\Resolution
 */
class WeekResolutionTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $res = new WeekResolution();
        $this->assertInstanceOf('Solution10\\Calendar\\Resolution\\WeekResolution', $res);
    }

    public function testConstructWithStartDay()
    {
        $res = new WeekResolution('Friday');
        $this->assertInstanceOf('Solution10\\Calendar\\Resolution\\WeekResolution', $res);
        $this->assertEquals('Friday', $res->startDay());
    }

    /*
     * ------------------ Testing Get/Set ----------------------
     */

    public function testGetSetDateTime()
    {
        $res = new WeekResolution();
        $this->assertNull($res->dateTime());

        $res->setDateTime(new DateTime('2014-05-27'));
        $this->assertEquals('2014-05-27', $res->dateTime()->format('Y-m-d'));
    }

    public function testGetSetStartDay()
    {
        $res = new WeekResolution();
        $this->assertEquals('Monday', $res->startDay());
        $this->assertEquals($res, $res->setStartDay('Wednesday'));
        $this->assertEquals('Wednesday', $res->startDay());
    }

    /*
     * ----------------- Testing Build Cells -------------------
     */

    public function testBuildCellsNoDate()
    {
        $res = new WeekResolution();
        $this->assertNull($res->build());
    }

    public function testBuildCellsWithDate()
    {
        $res = new WeekResolution();
        $res->setDateTime(new DateTime('2014-05-15'));
        $result = $res->build();

        $this->assertInstanceOf('Solution10\\Calendar\\Week', $result);

        // Verify that the start day has been applied:
        $days = $result->days();
        $this->assertEquals('Monday', $days[0]->date()->format('l'));
    }

    public function testBuildCellsWithDateSundayStart()
    {
        $res = new WeekResolution('Sunday');
        $res->setDateTime(new DateTime('2014-05-15'));
        $result = $res->build();

        $this->assertInstanceOf('Solution10\\Calendar\\Week', $result);

        // Verify that the start day has been applied:
        $days = $result->days();
        $this->assertEquals('Sunday', $days[0]->date()->format('l'));
    }
}
