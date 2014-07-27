<?php

namespace Solution10\Calendar;

use DateTime;

class Day
{
    /**
     * @var     DateTime   The datetime of this day
     */
    protected $today;

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
}
