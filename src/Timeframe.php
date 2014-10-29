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
}
