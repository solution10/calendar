<?php

namespace Solution10\Calendar\Resolution;

use DateTime;
use Solution10\Calendar\ResolutionInterface;
use Solution10\Calendar\Week;

/**
 * Class WeekResolution
 *
 * Displays only a single week of the Calendar. Useful for meeting views.
 *
 * @package     Solution10\Calendar\Resolution
 * @author      Alex Gisby <alex@solution10.com>
 * @license     MIT
 */
class WeekResolution implements ResolutionInterface
{
    /**
     * @var     DateTime    Current date, according to the resolution
     */
    protected $currentDate;

    /**
     * @var     string      Start day of the week
     */
    protected $startDay = 'Monday';

    /**
     * Constructor. You can pass in the start day
     *
     * @param   string|null  $startDay
     */
    public function __construct($startDay = null)
    {
        if ($startDay !== null) {
            $this->setStartDay($startDay);
        }
    }

    /**
     * Sets the start day of the resolution
     *
     * @param   string  $startDay
     * @return  $this
     */
    public function setStartDay($startDay)
    {
        $this->startDay = $startDay;
        return $this;
    }

    /**
     * Returns the start day we're using for this resolution
     *
     * @return  string
     */
    public function startDay()
    {
        return $this->startDay;
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

    /**
     * Returns the data for this view. Could be anything!
     *
     * @return  mixed
     */
    public function build()
    {
        if ($this->currentDate === null) {
            return null;
        }
        return new Week($this->currentDate, $this->startDay);
    }
}
