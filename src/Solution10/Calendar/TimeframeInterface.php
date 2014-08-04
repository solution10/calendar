<?php

namespace Solution10\Calendar;

use DateTime;

/**
 * Interface TimeframeInterface
 *
 * Timeframes are used to fetch events. You define a start and an end point
 * and then pass that to the calendar, which will work out which events
 * are pertinent.
 *
 * The Year, Month, Week and Day all implement this interface, so normally
 * you would use one of them, but this is here in case you want something
 * custom.
 *
 * @package     Solution10\Calendar
 * @author      Alex Gisby <alex@solution10.com>
 * @license     MIT
 */
interface TimeframeInterface
{
    /**
     * The start of this timeframe.
     *
     * @return  DateTime
     */
    public function start();

    /**
     * The end of this timeframe.
     *
     * @return  DateTime
     */
    public function end();
}
