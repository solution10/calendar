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
}
