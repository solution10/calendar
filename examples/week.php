<?php

require_once __DIR__.'/../vendor/autoload.php';

use Solution10\Calendar\Calendar;
use \Solution10\Calendar\Resolution\WeekResolution;

// Set up the calendar:
$calendar = new Calendar(new DateTime('2014-05-02'));

// Now you need to give it a "resolution". This tells the calendar how to display itself.
// In this case, we want to show a "week" view:
$calendar->setResolution(new WeekResolution());

$viewData = $calendar->viewData();

/* @var     $week     Solution10\Calendar\Week */
$week = $viewData['contents'];

// That's it! Let's render the calendar:
?>
<h2>Week</h2>

<table>
    <caption>
        <?php echo $week->weekStart()->format('j F'); ?>
        -
        <?php echo $week->weekEnd()->format('j F'); ?>
    </caption>
    <thead>
        <tr>
            <?php foreach ($week->days() as $day): ?>
                <th><?php echo $day->date()->format('l'); ?></th>
            <?php endforeach; ?>
        </tr>
        <tr>
            <?php foreach ($week->days() as $day): ?>
                <th><?php echo $day->date()->format('d'); ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php foreach ($week->days() as $day): ?>
                <td>
                    Nothing booked today...
                </td>
            <?php endforeach; ?>
        </tr>
    </tbody>
</table>

<hr>

<?php
// We can also start the week on a different day:
$calendar->resolution()->setStartDay('Sunday');
$viewData = $calendar->viewData();
/* @var     $week     Solution10\Calendar\Week */
$week = $viewData['contents'];
?>

<h2>Week (Sunday Start)</h2>

<table>
    <caption>
        <?php echo $week->weekStart()->format('j F'); ?>
        -
        <?php echo $week->weekEnd()->format('j F'); ?>
    </caption>
    <thead>
        <tr>
            <?php foreach ($week->days() as $day): ?>
                <th><?php echo $day->date()->format('l'); ?></th>
            <?php endforeach; ?>
        </tr>
        <tr>
            <?php foreach ($week->days() as $day): ?>
                <th><?php echo $day->date()->format('d'); ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php foreach ($week->days() as $day): ?>
                <td>
                    Hurray, your calendar is empty today!
                </td>
            <?php endforeach; ?>
        </tr>
    </tbody>
</table>
