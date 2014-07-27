<?php

namespace Solution10\Calendar;

use DateTime;
use Exception;
use Solution10\Calendar\Exception\Date as DateException;

/**
 * Class Month
 *
 * A class that represents a month in a given year. Can tell you all sorts of wonderful
 * things about that month like days, what day it started on etc.
 *
 * @package Solution10\Calendar
 */
class Month
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
     * Pass in the year and month number (1 = Jan, 2 = Feb etc)
     *
     * @param   int     $year
     * @param   int     $month
     * @throws  DateException
     */
    public function __construct($year, $month)
    {
        $startDate = $year.'-'.str_pad($month, 2, '0', STR_PAD_LEFT).'-01';

        try {
            $this->startDateTime = new DateTime($startDate);
        } catch (Exception $e) {
            throw new DateException($e->getMessage(), DateException::INVALID_DATE, $e);
        }

        $this->numDays = (int)$this->startDateTime->format('t');
        $endDate = $year
            .'-'.str_pad($month, 2, '0', STR_PAD_LEFT)
            .'-'.str_pad($this->numDays, 2, '0', STR_PAD_LEFT);

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
        return new Month($prevDateTime->format('Y'), $prevDateTime->format('n'));
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
        return new Month($nextDateTime->format('Y'), $nextDateTime->format('n'));
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
                    $this->weeks[$startDay][] = $candidateWeek;
                    $weekPoint->modify('+1 week');
                } else {
                    $keepWeeking = false;
                }
            }
        }
        return $this->weeks[$startDay];
    }
}
