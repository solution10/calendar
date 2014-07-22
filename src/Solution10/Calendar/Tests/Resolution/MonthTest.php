<?php

namespace Solution10\Calendar\Tests\Resolution;

use PHPUnit_Framework_TestCase;
use Solution10\Calendar\Resolution\Month as MonthResolution;

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
        $c = new MonthResolution(array('day' => false, 'month' => 7, 'year' => 1988));
        $this->assertInstanceOf('Solution10\\Calendar\\Resolution\\Month', $c);

        $c = new MonthResolution(array());
        $this->assertInstanceOf('Solution10\\Calendar\\Resolution\\Month', $c);
    }

    public function testBuildCellsNoDate()
    {
        $c = new MonthResolution(array());
        $this->assertEquals(array(), $c->buildCells());
    }
}
