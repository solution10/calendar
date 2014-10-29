<?php

namespace Solution10\Calendar\Tests;

use PHPUnit_Framework_TestCase;
use Solution10\Calendar\Event;
use DateTime;

class EventTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $title = 'Test Event';
        $start = new DateTime('2014-04-16 10:00:00');
        $end = new DateTime('2014-04-16 11:00:00');

        $e = new Event($title, $start, $end);
        $this->assertInstanceOf('Solution10\\Calendar\\Event', $e);
        $this->assertEquals($title, $e->title());
        $this->assertEquals($start, $e->start());
        $this->assertEquals($end, $e->end());
    }

    public function testSetGetStart()
    {
        $title = 'Test Event';
        $d1 = new DateTime('2014-04-16 10:00:00');
        $d2 = new DateTime('2014-04-16 11:00:00');

        $e = new Event($title, $d1, $d2);
        $this->assertEquals($d1, $e->start());
        $this->assertEquals($e, $e->setStart($d2));
        $this->assertEquals($d2, $e->start());
    }

    public function testSetGetEnd()
    {
        $title = 'Test Event';
        $d1 = new DateTime('2014-04-16 10:00:00');
        $d2 = new DateTime('2014-04-16 11:00:00');

        $e = new Event($title, $d1, $d1);
        $this->assertEquals($d1, $e->end());
        $this->assertEquals($e, $e->setEnd($d2));
        $this->assertEquals($d2, $e->end());
    }

    public function testSetGetTitle()
    {
        $title = 'Test Event';
        $start = new DateTime('2014-04-16 10:00:00');
        $end = new DateTime('2014-04-16 11:00:00');

        $e = new Event($title, $start, $end);
        $this->assertEquals($title, $e->title());

        $this->assertEquals($e, $e->setTitle('CHANGED'));
        $this->assertEquals('CHANGED', $e->title());
    }

    /**
     * @expectedException       \Solution10\Calendar\Exception\Event
     * @expectedExceptionCode   \Solution10\Calendar\Exception\Event::INVALID_DATES
     */
    public function testEndBeforeStart()
    {
        $title = 'Test Event';
        $start = new DateTime('2014-04-16 11:00:00');
        $end = new DateTime('2014-04-16 10:00:00');

        new Event($title, $start, $end);
    }

    /**
     * @expectedException       \Solution10\Calendar\Exception\Event
     * @expectedExceptionCode   \Solution10\Calendar\Exception\Event::INVALID_DATES
     */
    public function testStartAfterEnd()
    {
        $title = 'Test Event';
        $start = new DateTime('2014-04-16 10:00:00');
        $end = new DateTime('2014-04-16 11:00:00');

        $e = new Event($title, $start, $end);

        // Set an invalid date:
        $e->setStart(new DateTime('2014-04-17 11:00:00'));
    }
}
