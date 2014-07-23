<?php

namespace Solution10\Calendar\Tests\Resolution;

use PHPUnit_Framework_TestCase;
use Solution10\Calendar\Resolution\MonthResolution as MonthResolution;
use DateTime;

/**
 * Class MonthTest
 *
 * Tests out the Month resolution on the calendar.
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
class MonthTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $res = new MonthResolution(array('day' => false, 'month' => 7, 'year' => 1988));
        $this->assertInstanceOf('Solution10\\Calendar\\Resolution\\Month', $res);

        $res = new MonthResolution(array());
        $this->assertInstanceOf('Solution10\\Calendar\\Resolution\\Month', $res);
    }

    public function testBuildCellsNoDate()
    {
        $res = new MonthResolution(array());
        $this->assertEquals(array(), $res->buildCells());
    }

    /*
     * ------------------ Testing Month Overflows ----------------------
     */

    public function testSetGetMonthOverflowGood()
    {
        $res = new MonthResolution(array());
        $this->assertEquals($res, $res->setMonthOverflow(2, 3));

        $this->assertEquals(array(
            'left' => 2,
            'right' => 3
        ), $res->getMonthOverflow());
    }

    public function testSetGetMonthOverflowStrings()
    {
        $res = new MonthResolution(array());
        $res->setMonthOverflow('3', '4');

        $this->assertEquals(array(
            'left' => 3,
            'right' => 4
        ), $res->getMonthOverflow());
    }

    public function testSetGetMonthOverflowFloats()
    {
        $res = new MonthResolution(array());
        $res->setMonthOverflow('3.765', '4.123');

        $this->assertEquals(array(
            'left' => 3,
            'right' => 4
        ), $res->getMonthOverflow());
    }

    /*
     * ------------------ Testing Day Overflows ----------------
     */

    public function testSetGetDaysOverflow()
    {
        $res = new MonthResolution(array());
        $this->assertFalse($res->getDaysOverflow());

        $res->setDaysOverflow(true);
        $this->assertTrue($res->getDaysOverflow());
    }

    /*
     * ----------------- Testing Month Meta ---------------------
     */

    public function testMonthMeta()
    {
        $res = new MonthResolution(array('day' => 13, 'month' => 4, 'year' => 2014));
        $this->assertEquals(array(
            'startDate' => '2014-04-01',
            'startDay' => 2,
            'startDateTime' => new DateTime('2014-04-01'),
            'endDate' => '2014-04-30',
            'endDateTime' => new DateTime('2014-04-30'),
            'endDay' => 3,
            'totalDays' => 30,
            'isLeapYear' => false
        ), $res->getMonthMeta(4, 2014));
    }
}
