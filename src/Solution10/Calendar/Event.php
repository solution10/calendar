<?php

namespace Solution10\Calendar;

use DateTime;
use Solution10\Calendar\Exception\Event as EventException;

/**
 * Class Event
 *
 * This is a simple implementation of the EventInterface. Feel free to
 * use this in your apps, but it isn't super powerful. You'll either want
 * to subclass this, or rewrite to your needs.
 *
 * @package     Solution10\Calendar
 * @author      Alex Gisby <alex@solution10.com>
 * @license     MIT
 */
class Event implements EventInterface
{
    /**
     * @var     DateTime    Starting date time
     */
    protected $start = false;

    /**
     * @var     DateTime    End date time
     */
    protected $end = false;

    /**
     * @var     string      Event title
     */
    protected $title;

    /**
     * Constructor, pass in the start and end times.
     *
     * @param   string      $title  Title of this event.
     * @param   DateTime    $start  Starting date time
     * @param   DateTime    $end    Ending date time
     */
    public function __construct($title, DateTime $start, DateTime $end)
    {
        $this->setStart($start);
        $this->setEnd($end);
        $this->setTitle($title);
    }

    /**
     * Sets the start date of the event
     *
     * @param   DateTime    $start
     * @return  $this
     * @throws  \Solution10\Calendar\Exception\Event
     */
    public function setStart(DateTime $start)
    {
        if ($this->end && $start > $this->end) {
            throw new EventException(
                'New start comes after the end!',
                EventException::INVALID_DATES
            );
        }
        $this->start = clone $start;
        return $this;
    }

    /**
     * Returns the date and time this event starts.
     *
     * @return  DateTime
     */
    public function start()
    {
        return $this->start;
    }

    /**
     * Sets the end date of the event
     *
     * @param   DateTime    $end
     * @return  $this
     * @throws  \Solution10\Calendar\Exception\Event
     */
    public function setEnd(DateTime $end)
    {
        // Check the end is not before the start:
        if ($this->start && $end < $this->start) {
            throw new EventException(
                'New end comes after the start!',
                EventException::INVALID_DATES
            );
        }

        $this->end = clone $end;
        return $this;
    }

    /**
     * Returns the date and time that this event ends
     *
     * @return  DateTime
     */
    public function end()
    {
        return $this->end;
    }

    /**
     * Sets the title of this event
     *
     * @param   string  $title
     * @return  $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Returns the title of this event
     *
     * @return  string
     */
    public function title()
    {
        return $this->title;
    }
}
