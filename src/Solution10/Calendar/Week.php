<?php

namespace Solution10\Calendar;

use DateTime;

/**
 * Class Week
 *
 * Represents a week, either on its own or as a part of a monthly calendar.
 *
 * @package Solution10\Calendar
 */
class Week
{
    /**
     * @var     DateTime    Start of the week
     */
    protected $weekStart;

    /**
     * @var     DateTime    End of the week
     */
    protected $weekEnd;

    /**
     * For this constructor, pass in a date within the week you want to study.
     * Doesn't have to be the first day or last, as long as it's in that week
     * the class will adapt.
     *
     * @param   DateTime    $pointWithinWeek
     */
    public function __construct(DateTime $pointWithinWeek)
    {
        $this->weekStart = clone $pointWithinWeek;
        $this->weekStart->modify('Monday this week');

        $this->weekEnd = clone $pointWithinWeek;
        $this->weekEnd->modify('this Sunday');
    }

    /**
     * Returns the start of this week
     *
     * @return  DateTime
     */
    public function weekStart()
    {
        return $this->weekStart;
    }

    /**
     * Returns the last day of this week
     *
     * @return  DateTime
     */
    public function weekEnd()
    {
        return $this->weekEnd;
    }

}
