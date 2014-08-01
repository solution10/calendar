<?php

namespace Solution10\Calendar\Tests;

use PHPUnit_Framework_TestCase;
use Solution10\Calendar\Calendar;
use Solution10\Calendar\Resolution\MonthResolution as MonthResolution;
use DateTime;

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
        $this->assertEquals($dt, $c->getCurrentDate());

        $dt = new DateTime('1988-07-02');
        $c = new Calendar($dt);
        $this->assertEquals($dt, $c->getCurrentDate());
    }

    public function testGetDateTime()
    {
        $c = new Calendar(new DateTime('2000-01-01'));
        $this->assertEquals('2000-01-01', $c->getCurrentDate()->format('Y-m-d'));
    }

    /*
     * ------------------ Testing Resolution Management -----------------
     */

    public function testSetGetResolution()
    {
        $c = new Calendar(new DateTime());
        $res = new MonthResolution();
        $res->setDateTime($c->getCurrentDate());

        $this->assertEquals($c, $c->setResolution($res));
        $this->assertEquals($res, $c->getResolution());
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
