<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendancesExport;

class EventAttendanceController extends Controller
{
    // Show a form to create a new event
    public function createEventForm()
    {
        return view('events.create');
    }

    // Handle creating a new event
    public function createEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string|max:255',
            'event_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only('event_name', 'start_date', 'end_date');
        if ($request->hasFile('event_logo')) {
            $data['event_logo'] = $request->file('event_logo')->store('event_logos');
        }

        Event::create($data);

        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }

    // Show a list of events
    public function getEvents()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    // Show details of a specific event
    public function getEvent($id)
    {
        $event = Event::findOrFail($id);
        return view('events.show', compact('event'));
    }

    // Show a form to edit an event
    public function editEventForm($id)
    {
        $event = Event::findOrFail($id);
        return view('events.edit', compact('event'));
    }

    // Handle updating an event
    public function updateEvent(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'event_name' => 'sometimes|required|string|max:255',
            'event_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only('event_name', 'start_date', 'end_date');
        if ($request->hasFile('event_logo')) {
            $data['event_logo'] = $request->file('event_logo')->store('event_logos');
        }

        $event->update($data);

        return redirect()->route('events.show', $id)->with('success', 'Event updated successfully!');
    }

    // Handle deleting an event
    public function deleteEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }
    
    // Show a form to record attendance
    public function recordAttendanceForm($event_id)
    {
        $event = Event::findOrFail($event_id);
        return view('attendance.record', compact('event'));
    }

    // Handle recording attendance
    public function recordAttendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|exists:events,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $event = Event::find($request->event_id);
        $today = now()->toDateString();

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

        Attendance::create([
            'event_id' => $request->event_id,
            'user_id' => $request->user_id,
            'attendance_date' => $today,
        ]);

        return redirect()->route('events.show', $request->event_id)->with('success', 'Attendance recorded successfully!');
    }

    // Download attendance as Excel
    public function downloadAttendance($event_id)
    {
        $event = Event::findOrFail($event_id);
        return Excel::download(new AttendancesExport($event_id), "attendance_{$event->event_name}.xlsx");
    }

    // Show attendance records for an event
    public function getAttendance($event_id)
    {
        $event = Event::findOrFail($event_id);
        $attendances = Attendance::where('event_id', $event_id)->get();

        return view('attendance.index', compact('event', 'attendances'));
    }

    // Handle deleting attendance record
    public function deleteAttendance($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->back()->with('success', 'Attendance record deleted successfully!');
    }
}
