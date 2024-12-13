<!DOCTYPE html>
<html>
<head>
    <title>Events</title>
</head>
<body>
    <h1>Events</h1>
    <a href="{{ route('events.createEventForm') }}">Create Event</a>
    <ul>
        @foreach ($events as $event)
            <li>
                <a href="{{ route('events.show', $event->id) }}">{{ $event->event_name }}</a>
                ({{ $event->start_date }} - {{ $event->end_date }})
            </li>
        @endforeach
    </ul>
</body>
</html>
