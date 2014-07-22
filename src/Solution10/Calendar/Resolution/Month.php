<?php

namespace Solution10\Calendar\Resolution;

use Solution10\Calendar\ResolutionInterface;
use Solution10\Calendar\Cell;

/**
 * Class Month
 *
 * The month resolution shows a calendar that arranges the weeks by row,
 * the days by column and can optionally show multiple months at once:
 *
 *  | M | T | W | T | F | S | S |
 *  | 1 | 2 | 3 | 4 | 5 | 6 | 7 |
 *  | 8 | 9 | ... etc
 *
 * @package Solution10\Calendar\Resolution
 */
class Month implements ResolutionInterface
{
    /**
     * @var     array   The current date in it's array parts: Date parts ['day' => x, 'month' => y, 'year' => z]
     */
    protected $currentDate;

    /**
     * @var     int     The number of months to show either side of the current month.
     */
    protected $monthOverflow = 0;

    /**
     * @var     bool    Whether to show the overflow days in a month or not.
     */
    protected $daysOverflow = false;

    /**
     * Constructor should accept the current date.
     *
     * @param   array   $currentDate    Date parts ['day' => x, 'month' => y, 'year' => z]
     */
    public function __construct(array $currentDate)
    {
        $this->currentDate = $currentDate;
    }

    /**
     * Sets the number of months either side
     */

    /**
     * Returns an array of Cell objects representing the current Resolution.
     *
     * @return  Cell[]
     */
    public function buildCells()
    {

    }
}
