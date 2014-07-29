<?php

namespace Solution10\Calendar;

use DateTime;
use Solution10\Collection\Collection;

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
     * @var     Collection  Days of the week
     */
    protected $daysOfWeek;

    /**
     * @var     Day[]   Days that this week contains.
     */
    protected $days;

    /**
     * For this constructor, pass in a date within the week you want to study.
     * Doesn't have to be the first day or last, as long as it's in that week
     * the class will adapt.
     *
     * @param   DateTime    $pointWithinWeek
     * @param   string      $startDay           Day that the week starts on (in English, sorry)
     */
    public function __construct(DateTime $pointWithinWeek, $startDay = 'Monday')
    {
        // Work out the start of the week:
        $this->weekStart = clone $pointWithinWeek;
        if ($this->weekStart->format('l') != $startDay) {
            // We're not on the first day, so move backwards:
            $this->weekStart->modify('previous '.$startDay);
        }

        // And now the end of the week is just 6 days on:
        $this->weekEnd = clone $this->weekStart;
        $this->weekEnd->modify('+6 days');

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

    /**
     * Returns the days in this week.
     *
     * @return  Day[]
     */
    public function days()
    {
        if (!isset($this->days)) {
            $clonedStart = clone $this->weekStart;
            $this->days = array();
            for ($i = 0; $i < 7; $i ++) {
                $this->days[] = new Day($clonedStart);
                $clonedStart->modify('+1 day');
            }
        }
        return $this->days;
    }
}
