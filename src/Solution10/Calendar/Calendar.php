<?php

namespace Solution10\Calendar;

use DateTime;

/**
 * Class Calendar
 *
 * This is the starting point of your Calendars, everything comes from these instances.
 *
 * @package     Solution10\Calendar
 * @author      Alex Gisby <alex@solution10.com>
 * @license     MIT
 */
class Calendar
{
    /**
     * @var     int     The date the calendar is set to
     */
    protected $currentDay;

    /**
     * @var     int     The month the calendar is set to
     */
    protected $currentMonth;

    /**
     * @var     int     The year the calendar is set to
     */
    protected $currentYear;

    /**
     * @var     DateTime    The current date expressed as a DateTime instance.
     */
    protected $currentDateTime;

    /**
     * You can pass the current date in here:
     *
     * @param   bool|int    $day        Current day of the month (ie; 15)
     * @param   bool|int    $month      Current (numeric) month (ie February is 2)
     * @param   bool|int    $year       Current year (4 digits; 2014)
     */
    public function __construct($day = false, $month = false, $year = false)
    {
        $this->setCurrentDate($day, $month, $year);
    }

    /**
     * Sets the current date. The calendar uses this to work out which month to start on.
     * If you set any of these to false, it'll use a "safe default", which is usually today's
     * date, APART from the day which will default to the first, since months have variable
     * length.
     *
     * @param   bool|int    $day        Current day of the month (ie; 15)
     * @param   bool|int    $month      Current (numeric) month (ie February is 2)
     * @param   bool|int    $year       Current year (4 digits; 2014)
     * @return  $this
     * @throws  Exception\Date          Thrown when date is invalid.
     */
    public function setCurrentDate($day = false, $month = false, $year = false)
    {
        // Check that this date is valid by throwing it at DateTime
        $day = ($day === false) ? 1 : $day;
        $month = ($month === false) ? date('n') : $month;
        $year = ($year === false) ? date('Y') : $year;

        $combinedString = $year
            .'-'.str_pad($month, 2, '0', STR_PAD_LEFT)
            .'-'.str_pad($day, 2, '0', STR_PAD_LEFT);

        try {
            $dateTime = new DateTime($combinedString);
        } catch (\Exception $e) {
            // Nope, that date doesn't work, throw:
            throw new Exception\Date('Invalid date: '.$combinedString, Exception\Date::INVALID_DATE);
        }

        // Set the date;
        $this->currentDay       = $day;
        $this->currentMonth     = $month;
        $this->currentYear      = $year;
        $this->currentDateTime  = $dateTime;
    }

    /**
     * Gets the current date in it's constituent parts. So the return value is:
     *
     *      ['day' => 2, 'month' => 7', 'year' => 2020];
     *
     * @return  array   See above
     */
    public function getCurrentDate()
    {
        return array(
            'day' => $this->currentDay,
            'month' => $this->currentMonth,
            'year' => $this->currentYear
        );
    }
}
