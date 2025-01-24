<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendancesExport;

class EventAttendanceController extends Controller
{


    public function getEvents()
    {
        $events = Event::paginate(5);
        return view('events.index', compact('events'));
    }

    public function createEventForm()
    {
        return view('events.create');
    }

    public function createEvent(Request $request)
    {   
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // Create the event
        Event::create([
            'name' => $validated['name'],
            'logo' => $logoPath,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'created_by' => auth()->user()->user_id,
        ]);

        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }

    public function getEvent($id)
    {
        $event = Event::findOrFail($id);
        return view('events.attend', compact('event'));
    }

    public function editEventForm($id)
    {
        $event = Event::findOrFail($id);
        return view('events.edit', compact('event'));
    }

    public function updateEvent(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only('name', 'start_date', 'end_date');
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logo', 'public');
        }

        $event->update($data);

        return redirect()->route('events.index', $id)->with('success', 'Event updated successfully!');
    }

    public function deleteEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }
    
    public function recordAttendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Validation failed! Please provide all required inputs.')
                ->withInput();
        }

        $event = Event::find($request->event_id);
        $user = User::find($request->user_id);
        $today = now()->toDateString();

        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        if ($event->start_date > $today || $event->end_date < $today) {
            return redirect()->back()->with('error', 'Attendance is not allowed outside the event dates.');
        }

        $attendanceExists = Attendance::where([
            ['event_id', $request->event_id],
            ['user_id', $request->user_id],
            ['attendance_date', $today],
        ])->exists();

        if ($attendanceExists) {
            return redirect()->back()->with('error', 'User already attended this event today.');
        }

        try {
            Attendance::create([
                'event_id' => $request->event_id,
                'user_id' => $request->user_id,
                'attendance_date' => $today,
            ]);

            return redirect()->route('events.attend', $request->event_id)
                ->with('success', 'Attendance recorded successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to record attendance. Please try again.');
        }
    }


    public function getAttendance($event_id)
    {
        $event = Event::findOrFail($event_id);
        $attendances = Attendance::join('users', 'attendances.user_id', '=', 'users.user_id') // Join users table
            ->join('events', 'attendances.event_id', '=', 'events.id') // Join events table
            ->where('attendances.event_id', $event_id)
            ->select(
                'attendances.*', 
                'users.nama_lengkap as nama_lengkap', 
                'users.email as user_email', 
                'events.name as event_name', 
                'events.logo as event_logo'
            ) 
            ->orderBy('attendances.created_at', 'asc')
            ->paginate(15);

        return view('attendance.index', compact('attendances', 'event'));
    }


    public function downloadAttendanceCSV($event_id)
    {
        $event = Event::findOrFail($event_id);

        $attendances = Attendance::join('users', 'attendances.user_id', '=', 'users.user_id') // Join users table
            ->where('attendances.event_id', $event_id)
            ->select(
                'attendances.id as attendance_id',
                'users.user_id',
                'users.nama_lengkap as nama_lengkap',
                'users.email as user_email',
                'attendances.created_at as attendance_date'
            ) 
            ->orderBy('attendances.created_at', 'asc')
            ->get();

            // dd($attendances);
        $csvHeaders = [
            'Attendance ID',
            'User ID',
            'Full Name',
            'Email',
            'Attendance Date',
        ];

        $fileName = "absensi_event_{$event->name}.csv";

        $callback = function () use ($attendances, $csvHeaders) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $csvHeaders);

            foreach ($attendances as $attendance) {
                fputcsv($file, [
                    $attendance->attendance_id,
                    $attendance->user_id,
                    $attendance->nama_lengkap,
                    $attendance->user_email,
                    $attendance->attendance_date,
                ]);
            }

            fclose($file);
        };

        // Return response for CSV download
        return response()->stream($callback, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$fileName}",
        ]);
    }


    public function deleteAttendance($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->back()->with('success', 'Attendance record deleted successfully!');
    }
}
