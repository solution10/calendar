# Calendars

This section of the docs will teach you how to create and manage calendars.

The Calendar class is the starting point of the whole shebang, and the one
you'll probably spend most time playing with.

## Setting the Current Date

When creating a Calendar, you should give it the current date as a starting point.
However, whilst we say "current" date, it's up to you to decide what that means, it's
just the date the Calendar should consider "today".

So to create a Calendar centring on today, we would do this:

```php
$calendar = new Solution10\Calendar\Calendar(new DateTime('now'));
```

If I wanted to create a Calendar around the [Battle of Hastings](http://en.wikipedia.org/wiki/Battle_of_Hastings),
we would do the following:

```php
$calendar = new Solution10\Calendar\Calendar(new DateTime('1066-10-14'));
```

The time component of the DateTime is optional, it's the day we're interested in.

### Getting / Setting the current date

```php
$currentDate = $calendar->currentDate();
$calendar->setCurrentDate(new DateTime('2020-01-01 00:00:01'));
```

## Resolutions and Events

Before rendering a Calendar, you'll want to set a Resolution and add some Events.

Read about them in their relevant sections: [Resolutions](Resolutions), [Events](Events).

## Getting View Data

When you've manipulated your data enough, you'll want to get back data to render!

```php
$viewData = $calendar->viewData();
```

`$viewData` is an array with a single item "contents". Contents contains whatever data that the
Resolution returned, so you'll want to consult the docs for the Resolution you're using as to
what that is.

Why don't we just return the Resolution data? Simple; I'm paranoid. We might need to add something
else in here at some point, so it's future proofing.
