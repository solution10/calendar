<?php

namespace Solution10\Calendar\Resolution;

use DateTime;
use Solution10\Calendar\ResolutionInterface;
use Solution10\Calendar\Month;

/**
 * Class MonthResolution
 *
 * The month resolution shows a calendar that arranges the weeks by row,
 * the days by column and can optionally show multiple months at once:
 *
 *  | M | T | W | T | F | S | S |
 *  | 1 | 2 | 3 | 4 | 5 | 6 | 7 |
 *  | 8 | 9 | ... etc
 *
 * @package     Solution10\Calendar\Resolution
 * @author      Alex Gisby <alex@solution10.com>
 * @license     MIT
 */
class MonthResolution implements ResolutionInterface
{
    /**
     * @var     DateTime    Current date, according to the resolution
     */
    protected $currentDate;

    /**
     * @var     int     The number of months to show either side of the current month.
     */
    protected $monthOverflow = array('left' => 0, 'right' => 0);

    /**
     * @var     bool    Whether to show the overflow days in a month or not.
     */
    protected $daysOverflow = false;

    /**
     * Constructor takes three arguments, how many months left of current to show, how many right
     * of current to show, and whether to overflow days between the months.
     *
     * @param   int     $left           Number of months before current to show
     * @param   int     $right          Number of months after current to show
     * @param   bool    $overflowDays   Whether to show days belonging to other months or not.
     */
    public function __construct($left = 0, $right = 0, $overflowDays = false)
    {
        $this->setMonthOverflow($left, $right);
        $this->setShowOverflowDays($overflowDays);
    }

    /**
     * Setting the date on the Resolution
     *
     * @param   DateTime    $dateTime
     * @return  $this
     */
    public function setDateTime(DateTime $dateTime)
    {
        $this->currentDate = $dateTime;
        return $this;
    }

    /**
     * Returns the current date this Resolution thinks it is.
     *
     * @return  DateTime
     */
    public function dateTime()
    {
        return $this->currentDate;
    }

    /*
     * -------------------- Month Overflow -------------------
     */

    /**
     * Sets the number of months either side of the current one.
     * So if it's April, values of (1, 2) gives you March - April - May - June
     *
     * @param   int     $numLeft    Number to the left
     * @param   int     $numRight   Number to the right
     * @return  $this
     */
    public function setMonthOverflow($numLeft, $numRight)
    {
        $this->monthOverflow['left']    = (int)$numLeft;
        $this->monthOverflow['right']   = (int)$numRight;
        return $this;
    }

    /**
     * Returns the month overflows we're using. Return value is an array with 'left'
     * and 'right' keys.
     *
     * @return  array
     */
    public function monthOverflow()
    {
        return $this->monthOverflow;
    }

    /*
     * ----------------- Days Overflow --------------------
     */

    /**
     * Sets whether to show "overflow" days in months. These are days that
     * fill-up the ends of the week from other months rather than displaying
     * blank spaces.
     *
     * @param   bool    $useDaysOverflow    True for yes, false for no
     * @return  $this
     */
    public function setShowOverflowDays($useDaysOverflow)
    {
        $this->daysOverflow = (bool)$useDaysOverflow;
        return $this;
    }

    /**
     * Returns whether we are using day overflows or not
     *
     * @return  bool
     */
    public function showOverflowDays()
    {
        return $this->daysOverflow;
    }

    /*
     * --------------- Generating the Cells ------------------
     */

    /**
     * Returns the month objects to display
     *
     * @return  Month[]
     */
    public function build()
    {
        if (!isset($this->currentDate)) {
            return array();
        }

        // We need to know how many months to display, so that's the first job:
        $monthsToDisplay = array();
        $thisMonth = new Month($this->currentDate);

        // Go backwards first:
        for ($i = $this->monthOverflow['left']; $i != 0; $i --) {
            $monthsToDisplay[] = $thisMonth->prev($i);
        }

        // And the current:
        $monthsToDisplay[] = $thisMonth;

        // And then forwards:
        for ($i = 1; $i <= $this->monthOverflow['right']; $i ++) {
            $monthsToDisplay[] = $thisMonth->next($i);
        }

        return $monthsToDisplay;
    }
}
