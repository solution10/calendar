<?php

namespace Solution10\Calendar;

use DateTime;

/**
 * Interface EventInterface
 *
 * If you want to add events to the calendar, they must implement
 * this interface. It's nothing fancy, it just let's us know where
 * and when it occurs. You'll want a lot more than this in your events
 * no doubt, but S10 tries to keep things simple :)
 *
 * @package     Solution10\Calendar
 * @author      Alex Gisby <alex@solution10.com>
 * @license     MIT
 */
interface EventInterface
{
    /**
     * Returns the date and time this event starts.
     *
     * @return  DateTime
     */
    public function start();

    /**
     * Returns the date and time that this event ends
     *
     * @return  DateTime
     */
    public function end();
}
