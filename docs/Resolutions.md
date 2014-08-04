# Resolutions

Resolutions tell the Calendar how much data to build about itself and what
data is going to be relevant to the view.

Solution10\Calendar comes with two resolutions out of the box: Month and Week,
and you can easily write your own by implementing `ResolutionInterface`.

## MonthResolution

This resolution looks like the kind of Calendar you have hanging on your wall;
the weeks of the month arranged in a grid-view.

The MonthResolution allows you to also fetch months either side of the current
month, and set whether to display "overflow" days. But let's start simple.

### Single Month View:

```php
$calendar = Solution10\Calendar\Calender(new DateTime('now'));

// Add in the month resolution:
$calendar->setResolution(new Solution10\Calendar\MonthResolution());
```

By default, the MonthResolution does not display overflow days, and only
displays for the current month. So you'll end up with something like:

| M | T | W | T | F | S | S |
|---|---|---|---|---|---|---|
|   | 1 | 2 | 3 | 4 | 5 | 6 |
| 7 | 8 | 9 |10 |11 |12 |13 |
|14 |15 |16 |17 |18 |19 |20 |
|21 |22 |23 |24 |25 |26 |27 |
|28 |29 |30 |   |   |   |   |

### Multi-month View:

You might want to show months either side of the current month. Easy peasy!

```php
$calendar = Solution10\Calendar\Calender(new DateTime('now'));

// Add in the month resolution:
$calendar->setResolution(new Solution10\Calendar\MonthResolution(1, 2));
```

The first parameter is how many months before "current" to show, and the second
is how many months after "current" to show. So in the above example, if it
is current August 2014, the viewData would contain July - August - September - October.

### Overflow Days

Sometimes in a month, you'll have days at the beginning or end of a week
that don't belong to that month. For example, a month that starts on a Tuesday has
a little impostor from the previous month on the Monday.

You can tell the resolution whether you care about these days or not with the third
parameter:

```php
$calendar = Solution10\Calendar\Calender(new DateTime('now'));

// One month either side and we do care about overflows.
$calendar->setResolution(new Solution10\Calendar\MonthResolution(1, 1, true));
```

**NOTE**: The overflow days setting is really there as a hint for your view renderer,
it doesn't actually affect the data you get back from the Resolution.

### What do I get back?

```php
$calendar = Solution10\Calendar\Calender(new DateTime('now'));

// One month either side and we do care about overflows.
$calendar->setResolution(new Solution10\Calendar\MonthResolution(1, 1));

$viewData = $calendar->viewData();

/* @var     Month[]     $months     An array of Solution10\Calendar\Month objects */
$months = $viewData['contents'];
```

Within the 'contents' of $viewData you get an array of Month objects. From there you
can ask for the weeks() and from there, the days().

### Example Template code

It would be rude to leave you without an idea of how to render this, so here's some
example code in pure PHP:

```php
<?php foreach ($months as $month): ?>
<table>
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
```

## WeekResolution

The week resolution is similar to the Month, but much simpler. It only returns the data for a single
week rather than the whole month. This is how you use it:

```php
$calendar = new Calendar(new DateTime('2014-05-02'));
$calendar->setResolution(new WeekResolution());

$viewData = $calendar->viewData();

/* @var     $week     Solution10\Calendar\Week */
$week = $viewData['contents'];
```

The contents of $viewData this time round contains the instance of Solution10\Calendar\Week for
the current week. From there you can render the days().

### Example Template Code

Here's how you could render the template:

```php
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
```