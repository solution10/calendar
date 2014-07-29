<?php

namespace Solution10\Calendar;

use DateTime;

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
    public function getDateTime();

    /**
     * Returns the data for this view. Could be anything!
     *
     * @return  mixed
     */
    public function build();
}
