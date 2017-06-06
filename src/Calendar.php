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
     * @var     ResolutionInterface     The Resolution for this calendar to work to
     */
    protected $resolution;

    /**
     * @var     EventInterface[]     Events that have been added to the calendar
     */
    protected $events = array();

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
    public function currentDate()
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
        $this->resolution->setDateTime($this->currentDate());
        return $this;
    }

    /**
     * Returns the Resolution of this calendar.
     *
     * @return  ResolutionInterface
     */
    public function resolution()
    {
        return $this->resolution;
    }

    /*
     * --------------------- Events Functions --------------------
     */

    /**
     * Adding an event to the calendar
     *
     * @param   EventInterface   $event  The event to add
     * @return  $this
     */
    public function addEvent(EventInterface $event)
    {
        $this->events[] = $event;
        return $this;
    }

    /**
     * Add an array of EventInterface objects at once
     *
     * @param array $events The array of EventInterface objects
     * @return $this
     */
    public function addEvents(array $events)
    {
        foreach ($events as $event) {
            if ($event instanceof EventInterface) {
                $this->addEvent($event);
            }
        }
        return $this;
    }

    /**
     * Returns all of the events for the calendar
     *
     * @return  EventInterface[]
     */
    public function events()
    {
        return $this->events;
    }

    /**
     * Returns events for a given timeframe. Usually this is one of the
     * built in types (Year, Month, Week, Day) or you can pass in a custom
     * Timeframe instance if you're being fancy.
     *
     * The events will be sorted in Ascending order (earliest first)
     *
     * @param   TimeframeInterface   $timeframe
     * @return  EventInterface[]
     */
    public function eventsForTimeframe(TimeframeInterface $timeframe)
    {
        $events = array();

        foreach ($this->events as $event) {
            // Check if the start occurs within the timeframe:
            if ($event->start() >= $timeframe->start() && $event->start() <= $timeframe->end()) {
                $events[$event->start()->getTimestamp()] = $event;
            } elseif ($event->end() >= $timeframe->start() && $event->end() <= $timeframe->end()) {
                $events[$event->start()->getTimestamp()] = $event;
            }
        }

        // Sort by the keys and then return only the values:
        ksort($events);

        return array_values($events);
    }

    /*
     * -------------------- Rendering Functions ------------------
     */

    /**
     * Returns the data for your templating system to render the calendar.
     *
     * @return  array
     */
    public function viewData()
    {
        $resolutionData = $this->resolution->build();
        return array(
            'contents' => $resolutionData
        );
    }
}
