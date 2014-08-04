<?php

namespace Solution10\Calendar;

use DateTime;

/**
 * Class Week
 *
 * Represents a week, either on its own or as a part of a monthly calendar.
 *
 * @package     Solution10\Calendar
 * @author      Alex Gisby <alex@solution10.com>
 * @license     MIT
 */
class Week implements TimeframeInterface
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
     * @var     Month    Containing month (optional)
     */
    protected $containingMonth = null;

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
     * Sets the containing month of this week. Used to work out if
     * days are in overflow or not. Totally optional.
     *
     * @param   Month   $containingMonth
     * @return  $this
     */
    public function setContainingMonth(Month $containingMonth)
    {
        $this->containingMonth = clone $containingMonth;
        return $this;
    }

    /**
     * Gets the containing month
     *
     * @return  Month
     */
    public function containingMonth()
    {
        return $this->containingMonth;
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
                $thisDay = new Day($clonedStart);

                if (
                    $this->containingMonth
                    && $this->containingMonth->firstDay()->format('m') != $clonedStart->format('m')
                ) {
                    $thisDay->setIsOverflow(true);
                }

                $this->days[] = $thisDay;
                $clonedStart->modify('+1 day');
            }
        }
        return $this->days;
    }

    /*
     * ----------------- Implementing Timeframe ------------------
     */

    /**
     * The start of this timeframe.
     *
     * @return  DateTime
     */
    public function start()
    {
        return new DateTime($this->weekStart()->format('Y-m-d 00:00:00'));
    }

    /**
     * The end of this timeframe.
     *
     * @return  DateTime
     */
    public function end()
    {
        return new DateTime($this->weekEnd()->format('Y-m-d 23:59:59'));
    }
}
