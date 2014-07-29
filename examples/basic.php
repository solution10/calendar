<?php

require_once __DIR__.'/../vendor/autoload.php';

use Solution10\Calendar\Calendar;
use \Solution10\Calendar\Resolution\MonthResolution;

// Firstly, you need to create a "Resolution". This says what data
// to display and how. In this first example, let's do a standard single
// month view:

$singleMonth = new MonthResolution(array('year' => 2014, 'month' => 5));
$singleMonth->setMonthOverflow(0, 0);

// Set up the calendar itself:
$calendar = new Calendar(2014, 05, 02);
$calendar->setResolution($singleMonth);
//$calData = $calendar->
