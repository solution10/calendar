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

    public function testContainsDoesContain()
    {
        $t = new Timeframe(
            new \DateTime('2017-04-01'),
            new \DateTime('2017-04-10')
        );
        $this->assertTrue($t->contains(new \DateTime('2017-04-01')));
        $this->assertTrue($t->contains(new \DateTime('2017-04-05')));
        $this->assertTrue($t->contains(new \DateTime('2017-04-10')));
    }

    public function testContainsDoesNotContain()
    {
        $t = new Timeframe(
            new \DateTime('2017-04-01'),
            new \DateTime('2017-04-10')
        );
        $this->assertFalse($t->contains(new \DateTime('2017-03-30')));
        $this->assertFalse($t->contains(new \DateTime('2017-04-11')));
    }

    public function testTimeframeIntersectsBeginning()
    {
        $t = new Timeframe(
            new \DateTime('2017-04-01'),
            new \DateTime('2017-04-10')
        );

        $candidate = new Timeframe(new \DateTime('2017-03-28'), new \DateTime('2017-04-05'));
        $this->assertTrue($t->intersects($candidate));
    }

    public function testTimeframeIntersectsEnd()
    {
        $t = new Timeframe(
            new \DateTime('2017-04-01'),
            new \DateTime('2017-04-10')
        );

        $candidate = new Timeframe(new \DateTime('2017-04-08'), new \DateTime('2017-04-12'));
        $this->assertTrue($t->intersects($candidate));
    }

    public function testTimeframeIntersectsWithin()
    {
        $t = new Timeframe(
            new \DateTime('2017-04-01'),
            new \DateTime('2017-04-10')
        );

        $candidate = new Timeframe(new \DateTime('2017-04-03'), new \DateTime('2017-04-07'));
        $this->assertTrue($t->intersects($candidate));
    }

    public function testTimeframeIntersectsOverlay()
    {
        $t = new Timeframe(
            new \DateTime('2017-04-01'),
            new \DateTime('2017-04-10')
        );

        $candidate = new Timeframe(new \DateTime('2017-03-01'), new \DateTime('2017-05-31'));
        $this->assertTrue($t->intersects($candidate));
    }

    public function testTimeframeDoesNotIntersect()
    {
        $t = new Timeframe(
            new \DateTime('2017-04-01'),
            new \DateTime('2017-04-10')
        );

        $before = new Timeframe(new \DateTime('2017-03-01'), new \DateTime('2017-03-10'));
        $this->assertFalse($t->intersects($before));

        $after = new Timeframe(new \DateTime('2017-05-01'), new \DateTime('2017-05-10'));
        $this->assertFalse($t->intersects($after));
    }
}
