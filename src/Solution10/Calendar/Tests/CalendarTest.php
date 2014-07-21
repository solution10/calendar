<?php

namespace Solution10\Calendar\Tests;

use PHPUnit_Framework_TestCase;
use Solution10\Calendar\Calendar;

class CalendarTests extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $c = new Calendar();
        $this->assertInstanceOf('Solution10\\Calendar\\Calendar', $c);

        $c = new Calendar(false, false, false);
        $this->assertInstanceOf('Solution10\\Calendar\\Calendar', $c);

        $c = new Calendar(2, 7, 2014);
        $this->assertInstanceOf('Solution10\\Calendar\\Calendar', $c);
    }

    /**
     * @expectedException       \Solution10\Calendar\Exception\Date
     * @expectedExceptionCode   \Solution10\Calendar\Exception\Date::INVALID_DATE
     */
    public function testConstructBadDate()
    {
        new Calendar(40, -1, 'orange');
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

        $c = new Calendar(2, 7, 1988);
        $this->assertEquals(array(
            'day' => 2,
            'month' => 7,
            'year' => 1988
        ), $c->getCurrentDate());

        $c = new Calendar(false, 5, 2014);
        $this->assertEquals(array(
            'day' => 1,
            'month' => 5,
            'year' => 2014
        ), $c->getCurrentDate());

        $c = new Calendar(21, false, 1066);
        $this->assertEquals(array(
            'day' => 21,
            'month' => date('n'),
            'year' => 1066
        ), $c->getCurrentDate());

        $c = new Calendar(13, 10, false);
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
        new Calendar(40, 8, 2000);
    }

    /**
     * @expectedException       \Solution10\Calendar\Exception\Date
     * @expectedExceptionCode   \Solution10\Calendar\Exception\Date::INVALID_DATE
     */
    public function testSetBadDateMonth()
    {
        new Calendar(2, 13, 2000);
    }

    /**
     * @expectedException       \Solution10\Calendar\Exception\Date
     * @expectedExceptionCode   \Solution10\Calendar\Exception\Date::INVALID_DATE
     */
    public function testSetBadDateYear()
    {
        new Calendar(2, 8, 'pineapple');
    }
}
