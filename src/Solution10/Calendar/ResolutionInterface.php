<?php

namespace Solution10\Calendar;

interface ResolutionInterface
{
    /**
     * Constructor should accept the current date.
     *
     * @param   array   $currentDate    Date parts ['day' => x, 'month' => y, 'year' => z]
     */
    public function __construct(array $currentDate);

    /**
     * Return the date range expressed by this Resolution.
     * Return format should be:
     *
     *      ['start' => new DateTime(), 'end' => new DateTime()];
     *
     * @return  array
     */
    public function getDateRange();

    /**
     * Returns an array of Cell objects representing the current Resolution.
     *
     * @return  Cell[]
     */
    public function buildCells();
}
