<?php

namespace Solution10\Calendar;

use DateTime;

/**
 * Interface ResolutionInterface
 *
 * Calendar Resolutions must implement this interface.
 *
 * @package     Solution10\Calendar
 * @author      Alex Gisby <alex@solution10.com>
 * @license     MIT
 */
interface ResolutionInterface
{
    /**
     * Setting the date on the Resolution
     *
     * @param   DateTime    $dateTime
     * @return  $this
     */
    public function setDateTime(DateTime $dateTime);

    /**
     * Returns the current date this Resolution thinks it is.
     *
     * @return  DateTime
     */
    public function dateTime();

    /**
     * Returns the data for this view. Could be anything!
     *
     * @return  mixed
     */
    public function build();
}
