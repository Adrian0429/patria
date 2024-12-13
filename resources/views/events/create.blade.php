<!DOCTYPE html>
<html>
<head>
    <title>Create Event</title>
</head>
<body>
    <h1>Create Event</h1>
    <form action="{{ route('events.create') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="event_name">Event Name:</label>
        <input type="text" name="event_name" id="event_name" required><br>

        <label for="event_logo">Event Logo:</label>
        <input type="file" name="event_logo" id="event_logo"><br>

        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date" required><br>

        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date" required><br>

        <button type="submit">Create Event</button>
    </form>
</body>
</html>
