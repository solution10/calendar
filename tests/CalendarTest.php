<?php

namespace Solution10\Calendar\Tests;

use PHPUnit_Framework_TestCase;
use Solution10\Calendar\Calendar;
use Solution10\Calendar\EventInterface;
use Solution10\Calendar\Resolution\MonthResolution as MonthResolution;
use Solution10\Calendar\Event;
use Solution10\Calendar\Day;
use DateTime;
use Solution10\Calendar\Timeframe;
use stdClass;

class CalendarTests extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $c = new Calendar();
        $this->assertInstanceOf('Solution10\\Calendar\\Calendar', $c);

        $c = new Calendar(new DateTime('2014-07-02'));
        $this->assertInstanceOf('Solution10\\Calendar\\Calendar', $c);

        $c = new Calendar(new DateTime());
        $this->assertInstanceOf('Solution10\\Calendar\\Calendar', $c);
    }

    /*
     * --------------- Setting and Getting Dates ------------------
     */

    public function testSetGoodDate()
    {
        $dt = new DateTime();
        $c = new Calendar($dt);
        $this->assertEquals($dt, $c->currentDate());

        $dt = new DateTime('1988-07-02');
        $c = new Calendar($dt);
        $this->assertEquals($dt, $c->currentDate());
    }

    public function testGetDateTime()
    {
        $c = new Calendar(new DateTime('2000-01-01'));
        $this->assertEquals('2000-01-01', $c->currentDate()->format('Y-m-d'));
    }

    /*
     * ------------------ Testing Resolution Management -----------------
     */

    public function testSetGetResolution()
    {
        $c = new Calendar(new DateTime());
        $res = new MonthResolution();
        $res->setDateTime($c->currentDate());

        $this->assertEquals($c, $c->setResolution($res));
        $this->assertEquals($res, $c->resolution());
    }

    /*
     * ---------------- Testing events ------------------------
     */

    public function testAddRetrieveEvents()
    {
        $c = new Calendar(new DateTime('2014-05-27'));
        $this->assertEquals(array(), $c->events());

        $event = new Event('Standup', new DateTime('2014-05-27 10:00:00'), new DateTime('2014-05-27 10:15:00'));
        $this->assertEquals($c, $c->addEvent($event));

        $events = $c->events();
        $this->assertCount(1, $events);
        $this->assertEquals($event, $events[0]);
        $this->assertInstanceOf(EventInterface::class, $events[0]);
    }

    public function testAddMultipleEventsAtOnce()
    {
        $c = new Calendar(new DateTime('2014-05-27'));
        $this->assertEquals(array(), $c->events());

        $events = array(
            new Event('Standup', new DateTime('2014-05-27 10:00:00'), new DateTime('2014-05-27 10:15:00')),
            new Event('Standup', new DateTime('2014-05-27 10:00:00'), new DateTime('2014-05-27 10:15:00')),
        );

        $c->addEvents($events);

        $this->assertCount(2, $c->events());
        $this->assertInstanceOf(EventInterface::class, $c->events()[0]);
    }

    public function testAddMultipleEventsAppendsToExistingEvents()
    {
        $c = new Calendar(new DateTime('2014-05-27'));

        $e1 = new Event('Team Meeting', new DateTime('2014-05-27 15:00:00'), new DateTime('2014-05-27 16:00:00'));
        $e2 = new Event('Standup', new DateTime('2014-05-27 10:00:00'), new DateTime('2014-05-27 10:15:00'));

        // This event doesn't occur on the day
        $e3 = new Event('Standup', new DateTime('2014-05-28 10:00:00'), new DateTime('2014-05-28 10:15:00'));

        $c->addEvent($e1)
            ->addEvent($e2)
            ->addEvent($e3);

        $this->assertCount(3, $c->events());

        $events = array(
            new Event('Standup', new DateTime('2014-05-27 10:00:00'), new DateTime('2014-05-27 10:15:00')),
            new Event('Standup', new DateTime('2014-05-27 10:00:00'), new DateTime('2014-05-27 10:15:00')),
        );

        $c->addEvents($events);

        $this->assertCount(5, $c->events());
    }

    public function testAddMultipleEventsAtOnceFilterOutValuesThatDoesNotAdhereToTheEventInterface()
    {
        $c = new Calendar(new DateTime('2014-05-27'));

        $this->assertCount(0, $c->events());

        $events2 = [
            0 => new Event('Standup', new DateTime('2014-05-27 10:00:00'), new DateTime('2014-05-27 10:15:00')),
            1 => new StdClass('Standup', new DateTime('2014-05-27 10:00:00'), new DateTime('2014-05-27 10:15:00')),
            2 => 'kjhdfkjshdf',
            3 => [],
            4 => 0
        ];

        $c->addEvents($events2);

        $this->assertCount(1, $c->events());
        $this->assertInstanceOf(EventInterface::class, $c->events()[0]);
    }

    public function testEventsForTimeframe()
    {
        $c = new Calendar(new DateTime('2014-05-27'));

        // These two events occur on the given day (deliberately out of order to check sorting)
        $e1 = new Event('Team Meeting', new DateTime('2014-05-27 15:00:00'), new DateTime('2014-05-27 16:00:00'));
        $e2 = new Event('Standup', new DateTime('2014-05-27 10:00:00'), new DateTime('2014-05-27 10:15:00'));

        // This event doesn't occur on the day
        $e3 = new Event('Standup', new DateTime('2014-05-28 10:00:00'), new DateTime('2014-05-28 10:15:00'));

        $c->addEvent($e1)->addEvent($e2)->addEvent($e3);

        $day = new Day(new DateTime('2014-05-27'));
        $events = $c->eventsForTimeframe($day);

        $this->assertCount(2, $events);
        $this->assertEquals($e2, $events[0]);
        $this->assertEquals($e1, $events[1]);
    }

    public function testEventsForTimeframeEmpty()
    {
        $c = new Calendar(new DateTime('2014-05-27'));

        // Add an event that doesn't actually occur on this day:
        $e1 = new Event('Standup', new DateTime('2014-05-28 10:00:00'), new DateTime('2014-05-28 10:15:00'));
        $c->addEvent($e1);

        $day = new Day(new DateTime('2014-05-27'));
        $events = $c->eventsForTimeframe($day);
        $this->assertCount(0, $events);
    }

    public function testEventsStartBoundary()
    {
        $c = new Calendar(new DateTime('2014-05-27'));
        $e1 = new Event('Standup', new DateTime('2014-05-27 10:00:00'), new DateTime('2014-05-27 10:15:00'));
        $c->addEvent($e1);

        // This timeframe only contains the start, not the end of the event, but it should still be included:
        $timeframe = new Timeframe(new DateTime('2014-05-27 09:55:00'), new DateTime('2014-05-27 10:10:00'));
        $events = $c->eventsForTimeframe($timeframe);
        $this->assertCount(1, $events);
        $this->assertEquals($e1, $events[0]);
    }

    public function testEventsEndBoundary()
    {
        $c = new Calendar(new DateTime('2014-05-27'));
        $e1 = new Event('Standup', new DateTime('2014-05-27 10:00:00'), new DateTime('2014-05-27 10:15:00'));
        $c->addEvent($e1);

        // This timeframe only contains the end of the event, but it should still be included:
        $timeframe = new Timeframe(new DateTime('2014-05-27 10:10:00'), new DateTime('2014-05-27 10:30:00'));
        $events = $c->eventsForTimeframe($timeframe);
        $this->assertCount(1, $events);
        $this->assertEquals($e1, $events[0]);
    }

    /*
     * ---------------- Testing Getting View Data -----------------
     */

    public function testGetViewData()
    {
        $c = new Calendar(new DateTime('2014-05-27'));
        $c->setResolution(new MonthResolution());
        $viewData = $c->viewData();
        $this->assertArrayHasKey('contents', $viewData);
        $this->assertTrue(is_array($viewData['contents']));
    }
}
