# Events

A calendar is pretty boring without stuff on it! Well, Solution10\Calendar
is here to help on that front.

## EventInterface

All Event objects must implement `Solution10\Calendar\EventInterface`. It's a super
simple interface, requiring only and start `DateTime` and end `DateTime`. That's it!

If you want, you're more than welcome to write your own Event objects that implement
EventInterface. Or if you're lazy, we've got a built in one you can subclass or just use.

## Event

The Event class that comes with Calendar is super simple, a start, an end and a title:

```php
$e = new Event('Standup', new DateTime('2014-05-27 10:00:00'), new DateTime('2014-05-27 10:15:00'));
```

Check out the API docs for more on this object.

## Adding Events to Calendars:

Solution10\Calendar is really good at working out what events belong on what resolution,
so when adding events, feel free to be a bit over-generous on what you add. This way you
definitely won't miss anything off!

Once you have an event, adding it to a Calendar is simple:

```php
$c = new Calendar(new DateTime('2014-05-27'));
$e = new Event('Standup', new DateTime('2014-05-27 10:00:00'), new DateTime('2014-05-27 10:15:00'));
$c->addEvent($e);
```

You can even add muliple events at once:

```php
$c = new Calendar(new DateTime('2014-05-27'));
$e = [
  new Event('Standup', new DateTime('2014-05-27 10:00:00'), new DateTime('2014-05-27 10:15:00')),
  new Event('Standup', new DateTime('2014-05-27 10:00:00'), new DateTime('2014-05-27 10:15:00'))
];
$c->addEvents($e);
```

`addEvents` method will automatically filter out values in the array that does not adhere to the EventInterface. 

## Fetching Events

You can pull all of the events registered to the Calendar like so:

```php
$events = $calendar->events();
```

But that's a bit heavy handed. Very heavy handed in fact, they're un-sorted, jumbled up and generally
useless.

However there's a much smarter way:

```php
// I want all events on the 27th May 2014:
$day = new Solution10\Calendar\Day(new DateTime('2014-05-27'));
$dayEvents = $calendar->eventsForTimeframe($day);

// how about the week containing the 27th May?
$week = new Solution10\Calendar\Week(new DateTime('2014-05-27'));
$weekEvents = $calendar->eventsForTimeframe($week);

// Or how about everything in May 2014:
$month = new Solution10\Calendar\Month(new DateTime('2014-05-27'));
$monthEvents = $calendar->eventsForTimeframe($month);

// Or the entire year?
$year = new Solution10\Calendar\Year(2014);
$yearEvents = $calendar->eventsForTimeframe($year);
```

`eventsForTimeframe` always returns the events in start time ascending order. That means the array
goes from earlier to later.

So how does this work under the hood? Well, you can query using anything
that implements `TimeframeInterface`. The built-in types `Day`, `Week`, `Month`
and `Year` all implement this, so you can use them to query.

What if I want to query with a custom timeframe? Again, easy:

```php
$timeframe = new Timeframe(new DateTime('2014-05-27 10:10:00'), new DateTime('2014-05-27 10:30:00'));
$events = $calendar->eventsForTimeframe($timeframe);
```

The first parameter is the start time, and the second parameter is the end time.

**NOTE**: The comparisons for timeframes are <= and >=. That means that if your timeframe starts at
10:00am then events starting at 10:00am *will* be included.
