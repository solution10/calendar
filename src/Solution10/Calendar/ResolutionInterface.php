<?php

namespace Solution10\Calendar;

interface ResolutionInterface
{
    /**
     * Returns an array of Cell objects representing the current Resolution.
     *
     * @return  Cell[]
     */
    public function buildCells();
}
