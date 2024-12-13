<!DOCTYPE html>
<html>
<head>
    <title>Attendance for {{ $event->event_name }}</title>
</head>
<body>
    <h1>Attendance for {{ $event->event_name }}</h1>
    <a href="{{ route('attendance.recordForm', $event->id) }}">Record Attendance</a>
    <table border="1">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Attendance Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->user_id }}</td>
                    <td>{{ $attendance->attendance_date }}</td>
                    <td>
                        <form action="{{ route('attendance.delete', $attendance->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
