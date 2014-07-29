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
     * @var     DateTime    The current date expressed as a DateTime instance.
     */
    protected $currentDateTime;

    /**
     * @var     bool    Marks whether the calendar is set to a specific day or not. Used in rendering.
     */
    protected $specificDate = false;

    /**
     * @var     ResolutionInterface     The Resolution for this calendar to work to
     */
    protected $resolution;

    /**
     * You can pass the current date in here:
     *
     * @param   DateTime|null    $dateTime
     */
    public function __construct(DateTime $dateTime = null)
    {
        if ($dateTime !== null) {
            $this->setCurrentDate($dateTime);
        }
    }

    /**
     * Sets the current date
     *
     * @param   DateTime    $dateTime
     * @return  $this
     * @throws  Exception\Date          Thrown when date is invalid.
     */
    public function setCurrentDate(DateTime $dateTime)
    {
        $this->currentDateTime = clone $dateTime;
        return $this;
    }

    /**
     * Gets the current date of the Calendar.
     *
     * @return  DateTime
     */
    public function getCurrentDate()
    {
        return $this->currentDateTime;
    }

    /**
     * ---------------------- Display Options ---------------------
     */

    /**
     * Sets the Resolution of the Calendar. Resolutions decide how
     * many months to show either side, or whether to show a week
     * or work week.
     *
     * @param   ResolutionInterface    $res    Resolution to use
     * @return  $this
     */
    public function setResolution(ResolutionInterface $res)
    {
        $this->resolution = $res;
        $this->resolution->setDateTime($this->getCurrentDate());
        return $this;
    }

    /**
     * Returns the Resolution of this calendar.
     *
     * @return  ResolutionInterface
     */
    public function getResolution()
    {
        return $this->resolution;
    }
}
