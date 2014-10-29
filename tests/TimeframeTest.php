<?php

namespace Solution10\Calendar\Tests;

use PHPUnit_Framework_TestCase;
use Solution10\Calendar\Timeframe;
use DateTime;

class TimeframeTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $start = new DateTime('2014-05-27 10:00:00');
        $end = new DateTime('2014-05-27, 11:00:00');

        $t = new Timeframe($start, $end);
        $this->assertInstanceOf('Solution10\\Calendar\\Timeframe', $t);
        $this->assertEquals($start, $t->start());
        $this->assertEquals($end, $t->end());
    }

    /**
     * @expectedException       \Solution10\Calendar\Exception\Timeframe
     * @expectedExceptionCode   \Solution10\Calendar\Exception\Timeframe::INVALID_DATES
     */
    public function testConstructBadDates()
    {
        $start = new DateTime('2014-05-27, 11:00:00');
        $end = new DateTime('2014-05-27 10:00:00');
        new Timeframe($start, $end);
    }
}
