<?php

require_once __DIR__.'/../vendor/autoload.php';

use Solution10\Calendar\Calendar;
use \Solution10\Calendar\Resolution\MonthResolution;

// Set up the calendar:
$calendar = new Calendar(new DateTime('2014-05-02'));

// Now you need to give it a "resolution". This tells the calendar how to display itself.
// In this case, we want to show a "month" view:
$calendar->setResolution(new MonthResolution(1, 1, true));

$viewData = $calendar->viewData();

/* @var     $months     Solution10\Calendar\Month[] */
$months = $viewData['contents'];

// That's it! Let's render the calendar:
?>
<?php foreach ($months as $month): ?>
<table style="float: left; width: 25%; margin: 0 1%;">
    <caption><?php echo $month->firstDay()->format('F Y'); ?></caption>
    <thead>
        <tr>
            <?php foreach ($month->weeks()[0]->days() as $day): ?>
                <th><?php echo $day->date()->format('D'); ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($month->weeks() as $week): ?>
            <tr>
                <?php foreach ($week->days() as $day): ?>
                    <td>
                        <?php if ($calendar->getResolution()->getDaysOverflow() && $day->date()->format('m') != $month->firstDay()->format('m')): ?>
                            <span style="color: grey"><?php echo $day->date()->format('d'); ?></span>
                        <?php else: ?>
                            <?php echo $day->date()->format('d'); ?>
                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endforeach; ?>