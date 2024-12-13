<!DOCTYPE html>
<html>
<head>
    <title>Record Attendance for {{ $event->event_name }}</title>
</head>
<body>
    <h1>Record Attendance for {{ $event->event_name }}</h1>
    <form action="{{ route('attendance.record') }}" method="POST">
        @csrf
        <input type="hidden" name="event_id" value="{{ $event->id }}">

        <label for="user_id">User ID:</label>
        <input type="text" name="user_id" id="user_id" required><br>

        <button type="submit">Record Attendance</button>
    </form>
</body>
</html>
