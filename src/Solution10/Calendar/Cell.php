<?php

namespace Solution10\Calendar;

/**
 * Class Cell
 *
 * Each individual cell in a Calendar is an instance of this class.
 *
 * @package Solution10\Calendar
 */
class Cell
{
    /**
     * @var     array   The date-parts that this cell represents. (['day' => x, 'month' => x, 'year' => x])
     */
    protected $cellDate = array('day' => false, 'month' => false, 'year' => false);

    /**
     * @var     bool    Whether this cell is 'overflow'; ie the few days either side of the month
     */
    protected $isOverflow = false;

    /**
     * Constructor
     *
     * @param   array   $date   Date parts for this cell: (['day' => x, 'month' => x, 'year' => x])
     * @param   bool    $isOverflow     @see Cell::setIsOverflow()
     */
    public function __construct(array $date = array(), $isOverflow = false)
    {
        $this->setCellDate($date);
        $this->setIsOverflow($isOverflow);
    }

    /**
     * Sets the date for this cell. Values in the array should be integers or FALSE for not applicable.
     * All other values will be cast to (int)
     *
     * @param   array   $date   Date parts for this cell: (['day' => x, 'month' => x, 'year' => x])
     * @return  $this
     */
    public function setCellDate(array $date)
    {
        foreach ($date as $denom => $value) {
            if (array_key_exists($denom, $this->cellDate)) {
                $this->cellDate[$denom] = (is_bool($value)) ? $value : (int)$value;
            }
        }

        return $this;
    }

    /**
     * Gets the "day" of this cell, if set, false if not applicable.
     *
     * @return  int|bool
     */
    public function getDay()
    {
        return $this->cellDate['day'];
    }

    /**
     * Gets the "month" of this cell, if set, false if not applicable.
     *
     * @return  int|bool
     */
    public function getMonth()
    {
        return $this->cellDate['month'];
    }

    /**
     * Gets the "year" of this cell, if set, false if not applicable.
     *
     * @return  int|bool
     */
    public function getYear()
    {
        return $this->cellDate['year'];
    }

    /**
     * Sets whether this cell is "overflow" or not. Overflow is when you see a few days
     * of the previous or next month to fill the rest of the week.
     *
     * @param   bool    $isOverflow     true = yes it is, false = no it isn't
     * @return  $this
     */
    public function setIsOverflow($isOverflow)
    {
        $this->isOverflow = $isOverflow;
        return $this;
    }

    /**
     * Returns whether this cell is overflow or not.
     *
     * @see     Cell::setIsOverflow()
     * @return  bool
     */
    public function isOverflow()
    {
        return $this->isOverflow;
    }

    /**
     * Returns whether this cell is "blank" or not. A blank cell is one
     * which has no date attached to it, and is used as an overflow cell.
     *
     * @return  bool
     */
    public function isBlank()
    {
        return $this->cellDate['day'] === false
            && $this->cellDate['month'] === false
            && $this->cellDate['year'] === false;
    }
}
