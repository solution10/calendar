<?php

namespace Solution10\Calendar\Tests;

use PHPUnit_Framework_TestCase;
use Solution10\Calendar\Calendar;
use Solution10\Calendar\Resolution\MonthResolution as MonthResolution;

class CalendarTests extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $c = new Calendar();
        $this->assertInstanceOf('Solution10\\Calendar\\Calendar', $c);

        $c = new Calendar(false, false, false);
        $this->assertInstanceOf('Solution10\\Calendar\\Calendar', $c);

        $c = new Calendar(2014, 7, 2);
        $this->assertInstanceOf('Solution10\\Calendar\\Calendar', $c);
    }

    /**
     * @expectedException       \Solution10\Calendar\Exception\Date
     * @expectedExceptionCode   \Solution10\Calendar\Exception\Date::INVALID_DATE
     */
    public function testConstructBadDate()
    {
        new Calendar('orange', -1, 40);
    }

    /*
     * --------------- Setting and Getting Dates ------------------
     */

    public function testSetGoodDate()
    {
        $c = new Calendar();
        $this->assertEquals(array(
            'day' => 1,
            'month' => date('n'),
            'year' => date('Y')
        ), $c->getCurrentDate());

        $c = new Calendar(1988, 7, 2);
        $this->assertEquals(array(
            'day' => 2,
            'month' => 7,
            'year' => 1988
        ), $c->getCurrentDate());

        $c = new Calendar(2014, 5, false);
        $this->assertEquals(array(
            'day' => 1,
            'month' => 5,
            'year' => 2014
        ), $c->getCurrentDate());

        $c = new Calendar(1066, false, 21);
        $this->assertEquals(array(
            'day' => 21,
            'month' => date('n'),
            'year' => 1066
        ), $c->getCurrentDate());

        $c = new Calendar(false, 10, 13);
        $this->assertEquals(array(
            'day' => 13,
            'month' => 10,
            'year' => date('Y')
        ), $c->getCurrentDate());
    }

    /**
     * @expectedException       \Solution10\Calendar\Exception\Date
     * @expectedExceptionCode   \Solution10\Calendar\Exception\Date::INVALID_DATE
     */
    public function testSetBadDateDay()
    {
        new Calendar(2000, 8, 40);
    }

    /**
     * @expectedException       \Solution10\Calendar\Exception\Date
     * @expectedExceptionCode   \Solution10\Calendar\Exception\Date::INVALID_DATE
     */
    public function testSetBadDateMonth()
    {
        new Calendar(2000, 13, 2);
    }

    /**
     * @expectedException       \Solution10\Calendar\Exception\Date
     * @expectedExceptionCode   \Solution10\Calendar\Exception\Date::INVALID_DATE
     */
    public function testSetBadDateYear()
    {
        new Calendar('pineapple', 8, 2);
    }

    public function testGetDateTime()
    {
        $c = new Calendar(2000, 1, 1);
        $this->assertEquals('2000-01-01', $c->getCurrentDateTime()->format('Y-m-d'));
    }

    public function testSpecificDate()
    {
        $c = new Calendar(2000, 1, 1);
        $this->assertTrue($c->isSpecificDate());

        $c = new Calendar(2000, 1);
        $this->assertFalse($c->isSpecificDate());
    }

    /*
     * ------------------ Testing Resolution Management -----------------
     */

    public function testSetGetResolution()
    {
        $c = new Calendar();
        $res = new MonthResolution($c->getCurrentDate());

        $this->assertEquals($c, $c->setResolution($res));
        $this->assertEquals($res, $c->getResolution());
    }
}
