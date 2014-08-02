<?php

require_once __DIR__.'/../vendor/autoload.php';

use Solution10\Calendar\Calendar;
use \Solution10\Calendar\Resolution\MonthResolution;

// Set up the calendar:
$calendar = new Calendar(new DateTime('2014-05-02'));

// Now you need to give it a "resolution". This tells the calendar how to display itself.
// In this case, we want to show a "month" view:
$calendar->setResolution(new MonthResolution());

$viewData = $calendar->viewData();

/* @var     $months     Solution10\Calendar\Month[] */
$months = $viewData['contents'];

// That's it! Let's render the calendar:
?>
<h2>Just May</h2>
<?php foreach ($months as $month): ?>
<table style="float: left; width: 25%; margin: 0 1%;">
    <caption><?php echo $month->title('F Y'); ?></caption>
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
                        <?php
                            if ($day->isOverflow()) {
                                if ($calendar->resolution()->showOverflowDays()) {
                                    echo '<span style="color: #ccc">'.$day->date()->format('d').'</span>';
                                } else {
                                    echo '&nbsp;';
                                }
                            } else {
                                echo $day->date()->format('d');
                            }
                        ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endforeach; ?>

<hr style="clear: both;">

<?php
// We can also modify the resolution in place and re-render the calendar.
// Let's ask the calendar to render a month either side.

$calendar->resolution()->setMonthOverflow(1, 1);
$viewData = $calendar->viewData();

/* @var     $months     Solution10\Calendar\Month[] */
$months = $viewData['contents'];
?>

<h2>May and Friends</h2>
<?php foreach ($months as $month): ?>
    <table style="float: left; width: 25%; margin: 0 1%;">
        <caption><?php echo $month->title('F Y'); ?></caption>
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
                        <?php
                        if ($day->isOverflow()) {
                            if ($calendar->resolution()->showOverflowDays()) {
                                echo '<span style="color: #ccc">'.$day->date()->format('d').'</span>';
                            } else {
                                echo '&nbsp;';
                            }
                        } else {
                            echo $day->date()->format('d');
                        }
                        ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endforeach; ?>

<hr style="clear: both;">

<?php

// And finally, we can also display days from other months,
// otherwise known as overflowing:

$calendar->resolution()->setShowOverflowDays(true);
$viewData = $calendar->viewData();

/* @var     $months     Solution10\Calendar\Month[] */
$months = $viewData['contents'];
?>

<h2>Months with Overflows</h2>
<?php foreach ($months as $month): ?>
    <table style="float: left; width: 25%; margin: 0 1%;">
        <caption><?php echo $month->title('F Y'); ?></caption>
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
                        <?php
                        if ($day->isOverflow()) {
                            if ($calendar->resolution()->showOverflowDays()) {
                                echo '<span style="color: #ccc">'.$day->date()->format('d').'</span>';
                            } else {
                                echo '&nbsp;';
                            }
                        } else {
                            echo $day->date()->format('d');
                        }
                        ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endforeach; ?>