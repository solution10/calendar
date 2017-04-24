<?php

namespace Solution10\Calendar;

use DateTime;

/**
 * Class Timeframe
 *
 * This is an example implementation of a Timeframe. You can use this to define
 * boundaries for event fetching, or you can implement your own TimeframeInterface
 * implementation.
 *
 * @package Solution10\Calendar
 */
class Timeframe implements TimeframeInterface
{
    /**
     * @var     DateTime    Timeframe start
     */
    protected $start;

    /**
     * @var     DateTime    Timeframe end
     */
    protected $end;

    /**
     * Pass in the start and end point of the timeframe.
     *
     * @param   DateTime    $start  Start point
     * @param   DateTime    $end    End point
     * @throws  Exception\Timeframe
     */
    public function __construct(DateTime $start, DateTime $end)
    {
        if ($end < $start) {
            throw new Exception\Timeframe(
                'End is before the start',
                Exception\Timeframe::INVALID_DATES
            );
        }

        $this->start = clone $start;
        $this->end = clone $end;
    }

    /**
     * The start of this timeframe.
     *
     * @return  DateTime
     */
    public function start()
    {
        return $this->start;
    }

    /**
     * The end of this timeframe.
     *
     * @return  DateTime
     */
    public function end()
    {
        return $this->end;
    }

    /**
     * Returns whether a timeframe contains a given date.
     *
     * @param   \DateTime   $dt
     * @return  bool
     */
    public function contains(\DateTime $dt)
    {
        return ($this->start <= $dt && $this->end >= $dt);
    }

    /**
     * Returns whether this timeframe intersects with another timeframe; some part of this timeframe
     * overlaps with the given timeframe.
     *
     * @param   TimeframeInterface  $frame
     * @return  bool
     */
    public function intersects(TimeframeInterface $frame)
    {
        return
            // Checks intersections within:
            ($this->contains($frame->start()) || $this->contains($frame->end()))
            // Checks full overlaps:
            || ($frame->start() <= $this->start && $frame->end() >= $this->end)
        ;
    }
}
