<?php

namespace Solution10\Calendar;

use DateTime;

/**
 * Class Month
 *
 * A class that represents a month in a given year. Can tell you all sorts of wonderful
 * things about that month like days, what day it started on etc.
 *
 * @package     Solution10\Calendar
 * @author      Alex Gisby <alex@solution10.com>
 * @license     MIT
 */
class Month implements TimeframeInterface
{
    /**
     * @var     DateTime    DateTime for the first day of the month.
     */
    protected $startDateTime;

    /**
     * @var     DateTime    DateTime for the last day of the month.
     */
    protected $endDateTime;

    /**
     * @var     int     Number of days in the month.
     */
    protected $numDays = 31;

    /**
     * @var     Year    Year this month belongs to.
     */
    protected $year;

    /**
     * @var     array   Array containing the weeks of this month
     */
    protected $weeks = array();

    /**
     * Pass in a DateTime at some point within the month you want to
     * represent. So Month(new DateTime('2014-04-08')) will give April 2014.
     * The day component of the date is ignored.
     *
     * @param   DateTime    $pointWithinMonth   Some date within the month
     */
    public function __construct(DateTime $pointWithinMonth)
    {
        $year = $pointWithinMonth->format('Y');
        $month = $pointWithinMonth->format('m');

        $startDate = $year.'-'.$month.'-01';
        $this->startDateTime = new DateTime($startDate);

        $this->numDays = (int)$this->startDateTime->format('t');

        $endDate = $year.'-'.$month.'-'.str_pad($this->numDays, 2, '0', STR_PAD_LEFT);
        $this->endDateTime = new DateTime($endDate);
    }

    /**
     * Returns the first day of the month.
     *
     * @return  DateTime
     */
    public function firstDay()
    {
        return $this->startDateTime;
    }

    /**
     * Returns the last day of the month
     *
     * @return  DateTime
     */
    public function lastDay()
    {
        return $this->endDateTime;
    }

    /**
     * Returns the number of days in the month
     *
     * @return  int
     */
    public function numDays()
    {
        return $this->numDays;
    }

    /**
     * Returns a year object for this month
     *
     * @return  Year
     */
    public function year()
    {
        if (!isset($this->year)) {
            $this->year = new Year($this->startDateTime->format('Y'));
        }
        return $this->year;
    }

    /**
     * Grabs a "previous" month given by an offset. So if this
     * month is April, a prev(1) will give March. prev(2) will give February.
     *
     * @param   int     $offset     Offset
     * @return  Month
     */
    public function prev($offset = 1)
    {
        $prevDateTime = clone $this->startDateTime;
        $prevDateTime->modify('-'.abs($offset).' months');
        return new Month($prevDateTime);
    }

    /**
     * Grabs a "next" month given by an offset. So if this
     * month is April, a prev(1) will give March. prev(2) will give February.
     *
     * @param   int     $offset     Offset
     * @return  Month
     */
    public function next($offset = 1)
    {
        $nextDateTime = clone $this->startDateTime;
        $nextDateTime->modify('+'.abs($offset).' months');
        return new Month($nextDateTime);
    }

    /**
     * Returns the weeks associated with this month. Not all of these weeks might
     * start and end in this month, but they all contain days from this month.
     *
     * @param   string  $startDay   The day that weeks start on.
     * @return  Week[]
     */
    public function weeks($startDay = 'Monday')
    {
        if (!isset($this->weeks[$startDay])) {
            $this->weeks[$startDay] = array();
            $keepWeeking = true;
            $weekPoint = clone $this->firstDay();

            while ($keepWeeking) {
                $candidateWeek = new Week($weekPoint, $startDay);
                if ($candidateWeek->weekStart() <= $this->lastDay()) {
                    $candidateWeek->setContainingMonth($this);
                    $this->weeks[$startDay][] = $candidateWeek;
                    $weekPoint->modify('+1 week');
                } else {
                    $keepWeeking = false;
                }
            }
        }
        return $this->weeks[$startDay];
    }

    /**
     * This is a shortcut for $month->firstDay()->format() but it
     * just makes for a prettier API
     *
     * @param   string  $format     DateTime::format() suitable string
     * @return  string
     */
    public function title($format)
    {
        return $this->firstDay()->format($format);
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
        return new DateTime($this->firstDay()->format('Y-m-d 00:00:00'));
    }

    /**
     * The end of this timeframe.
     *
     * @return  DateTime
     */
    public function end()
    {
        return new DateTime($this->lastDay()->format('Y-m-d 23:59:59'));
    }
}
