# Solution10\Calendar

The Calendar component is a simple, but powerful package to help you in the rendering of, well, Calendars!

[![Build Status](https://travis-ci.org/Solution10/calendar.svg?branch=master)](https://travis-ci.org/Solution10/calendar)
[![Latest Stable Version](https://poser.pugx.org/solution10/calendar/v/stable.svg)](https://packagist.org/packages/solution10/calendar)
[![Total Downloads](https://poser.pugx.org/solution10/calendar/downloads.svg)](https://packagist.org/packages/solution10/calendar)
[![License](https://poser.pugx.org/solution10/calendar/license.svg)](https://packagist.org/packages/solution10/calendar)

## Features

- No dependancies
- PHP 5.3+
- Straightforward interface
- Support for multiple "resolutions" (week view, month view etc)
- Easily extended
- Templating system agnostic

## Getting Started

Installation is via composer, in the usual manner:

```json
{
    "require": {
        "solution10/calendar": "^1.0"
    }
}
```

Creating a basic calendar is as such:

```php
<?php
// Creates a calendar, using today as a starting point.
$calendar = new Solution10\Calendar\Calendar(new DateTime('now'));

// We now need to give the calendar a "resolution". This tells the
// Calendar whether we're showing a month view, or a Week, or maybe
// even a whole year. Let's start with a Month:

$calendar->setResolution(new MonthResolution());

// That's it! Let's grab the view data and render:
$viewData = $calendar->viewData();
$months = $viewData['contents'];
?>

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

Solution10\Calendar does not provide you with templates as we have no idea what templating
engine (if any) you're using. Instead, we give you a powerful and simple API so you can
do the rendering yourself.

## Further Reading

### Userguide

For more information on creating Calendars, see the [Calendars Section](http://github.com/solution10/calendar/wiki/Calendars).

If you want to know more about Resolutions, check out the [Resolutions Section](http://github.com/solution10/calendar/wiki/Resolutions).

Want to see how you can add Events to your calendars? You'll be wanting the [Events Section](http://github.com/solution10/calendar/wiki/Events).

## PHP Requirements

- PHP >= 5.3

## Author

Alex Gisby: [GitHub](http://github.com/alexgisby), [Twitter](http://twitter.com/alexgisby)

## License

[MIT](http://github.com/solution10/calendar/tree/master/LICENSE.md)

## Contributing

[Contributors Notes](http://github.com/solution10/calendar/tree/master/CONTRIBUTING.md)
