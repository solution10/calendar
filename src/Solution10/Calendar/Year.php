<?php

namespace Solution10\Calendar;

use DateTime;
use Exception;
use Solution10\Calendar\Exception\Date as DateException;

/**
 * Class Year
 *
 * A tiny and simple class that represents a year.
 *
 * @package Solution10\Calendar
 */
class Year
{
    /**
     * @var     DateTime    First of Jan that year.
     */
    protected $newYearsDay;

    /**
     * Pass in just the year
     *
     * @param   int     $year
     * @throws  DateException
     */
    public function __construct($year)
    {
        try {
            $this->newYearsDay = new DateTime($year.'-01-01');
        } catch (Exception $e) {
            throw new DateException($e->getMessage(), DateException::INVALID_DATE, $e);
        }
    }

    /**
     * Returns the full year this represents
     *
     * @return  int
     */
    public function yearFull()
    {
        return $this->newYearsDay->format('Y');
    }

    /**
     * Returns the short year this represents
     *
     * @return  int
     */
    public function yearShort()
    {
        return $this->newYearsDay->format('y');
    }

    /**
     * Returns whether this is a leap year or not.
     *
     * return   bool
     */
    public function isLeapYear()
    {
        return (bool)$this->newYearsDay->format('L');
    }
}
