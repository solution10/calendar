<?php

namespace Solution10\Calendar;

use DateTime;

/**
 * Class Day
 *
 * Represents a Day in the Calendar.
 *
 * @package     Solution10\Calendar
 * @author      Alex Gisby <alex@solution10.com>
 * @license     MIT
 */
class Day implements TimeframeInterface
{
    /**
     * @var     DateTime   The datetime of this day
     */
    protected $today;

    /**
     * @var     bool    Whether this day is an "overflow" day between months or not.
     */
    protected $isOverflow = false;

    /**
     * Pass in the date that this day represents.
     *
     * @param   DateTime    $date
     */
    public function __construct(DateTime $date)
    {
        $this->today = clone $date; // take a copy just to be safe.
    }

    /**
     * Returns the date of this day.
     *
     * @return   DateTime
     */
    public function date()
    {
        return $this->today;
    }

    /**
     * Sets whether this day is overflow
     *
     * @param   bool    $isOverflow
     * @return  $this
     */
    public function setIsOverflow($isOverflow)
    {
        $this->isOverflow = $isOverflow;
    }

    /**
     * Returns whether this day is overflow or not
     *
     * @return  bool
     */
    public function isOverflow()
    {
        return $this->isOverflow;
    }

    /*
     * ------------------- Timeframe Interface -----------------
     */
    /**
     * The start of this timeframe.
     *
     * @return  DateTime
     */
    public function start()
    {
        return new DateTime($this->today->format('Y-m-d 00:00:00'));
    }

    /**
     * The end of this timeframe.
     *
     * @return  DateTime
     */
    public function end()
    {
        return new DateTime($this->today->format('Y-m-d 23:59:59'));
    }
}
