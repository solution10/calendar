<?php

namespace Solution10\Calendar\Tests;

use PHPUnit_Framework_TestCase;
use Solution10\Calendar\Day;
use DateTime;

class DayTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $d = new Day(new DateTime('2014-04-16'));
        $this->assertInstanceOf('Solution10\\Calendar\\Day', $d);
    }

    public function testDate()
    {
        $d = new Day(new DateTime('2014-04-16'));
        $this->assertEquals('2014-04-16', $d->date()->format('Y-m-d'));
    }

    public function testDateDoesntMove()
    {
        $dt = new DateTime('2014-04-16');
        $d = new Day($dt);

        $dt->modify('+1 day');
        $this->assertEquals('2014-04-17', $dt->format('Y-m-d'));
        $this->assertEquals('2014-04-16', $d->date()->format('Y-m-d'));
    }

    public function testGetSetIsOverflow()
    {
        $d = new Day(new DateTime('2014-04-16'));
        $this->assertFalse($d->isOverflow());

        $d->setIsOverflow(true);
        $this->assertTrue($d->isOverflow());
    }

    public function testTimeframeImplementation()
    {
        $d = new Day(new DateTime('2014-04-16'));
        $this->assertEquals('2014-04-16 00:00:00', $d->start()->format('Y-m-d H:i:s'));
        $this->assertEquals('2014-04-16 23:59:59', $d->end()->format('Y-m-d H:i:s'));
    }
}
