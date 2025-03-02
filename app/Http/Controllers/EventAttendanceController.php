<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Attendance;
use App\Models\DataAnggota;
use App\Models\InformasiAkses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendancesExport;

class EventAttendanceController extends Controller
{

    public function getEvents(Request $request)
    {
        $user = auth()->user();
        $search = $request->query('search'); // Capture the search query

        // Initialize the query
        if ($user->jabatan === 'admin' || $user->jabatan === 'DPP') {
            $query = Event::query()
                ->select('events.*', 'users.nama', 'users.jabatan', 'dpd.nama_dpd', 'dpc.nama_dpc')
                ->join('users', 'events.user_id', '=', 'users.id')
                ->leftJoin('dpd', 'users.dpd_id', '=', 'dpd.id')
                ->leftJoin('dpc', 'users.dpc_id', '=', 'dpc.id');
        } else {
            $query = Event::query()
                ->select('events.*', 'users.nama', 'users.jabatan', 'dpd.nama_dpd', 'dpc.nama_dpc')
                ->join('users', 'events.user_id', '=', 'users.id')
                ->leftJoin('dpd', 'users.dpd_id', '=', 'dpd.id')
                ->leftJoin('dpc', 'users.dpc_id', '=', 'dpc.id')
                ->where('events.user_id', $user->id);
        }

        // Apply search filter if a search term is provided
        if ($search) {
            $query->where('events.nama_event', 'LIKE', "%{$search}%");
        }

        // Paginate the results
        $events = $query->paginate(7);

        return view('events.index', compact('events', 'search'));
    }


    public function createEventForm()
    {
        return view('events.create');
    }

    public function createEvent(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create an event.');
        }

        $validated = $request->validate([
            'nama_event' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Debugging: Check if user_id is correctly retrieved
        \Log::info('Creating Event', ['user_id' => auth()->user()->id]);

        $event = Event::create([
            'nama_event' => $validated['nama_event'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'user_id' => auth()->user()->id,
        ]);

        InformasiAkses::create([
            'type' => 'create',
            'keterangan' => 'data event ' . $event->nama_event . ' dibuat',
            'user_id' => Auth::id(),
            'nama_penginput' => Auth::user()->nama ?? 'Unknown',
            'jabatan_penginput' => Auth::user()->jabatan ?? 'Unknown',
            'created_at' => now(), // Manually set 'created_at'
        ]);


        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }


    public function editEventForm($id)
    {
        $event = Event::findOrFail($id);
        return view('events.edit', compact('event'));
    }


  public function updateEvent(Request $request, $id)
    {
        // Find the event and check if it exists
        $event = Event::findOrFail($id);

        // Ensure only the creator or an admin can update the event
        if (auth()->user()->jabatan !== 'admin' && $event->user_id !== auth()->user()->id) {
            return redirect()->route('events.index')->with('error', 'You are not authorized to update this event.');
        }

        // Validate the input
        $validator = Validator::make($request->all(), [
            'nama_event' => 'sometimes|required|string|max:255',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Prepare the data for updating (Correct field names)
        $data = $request->only('nama_event', 'start_date', 'end_date');

        // Handle file upload correctly
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $event->update($data);


        InformasiAkses::create([
            'type' => 'update',
            'keterangan' => 'data event ' . $event->nama_event . ' dirubah',
            'user_id' => Auth::id(),
            'nama_penginput' => Auth::user()->nama ?? 'Unknown',
            'jabatan_penginput' => Auth::user()->jabatan ?? 'Unknown',
            'created_at' => now(), // Manually set 'created_at'
        ]);


        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    public function getEvent($id)
    {
        $event = Event::findOrFail($id);
        return view('events.attend', compact('event'));
    }

    public function deleteEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();


        InformasiAkses::create([
            'type' => 'delete',
            'keterangan' => 'data event' . $event->nama_event . ' dihapus',
            'user_id' => Auth::id(),
            'nama_penginput' => Auth::user()->nama ?? 'Unknown',
            'jabatan_penginput' => Auth::user()->jabatan ?? 'Unknown',
            'created_at' => now(), // Manually set 'created_at'
        ]);

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

        // Find the user by either 'id' or 'ID_Kartu'
        $user = DataAnggota::where('id', $request->user_id)
            ->orWhere('ID_Kartu', $request->user_id)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $event = Event::find($request->event_id);
        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        $today = now()->toDateString();
        if ($event->start_date > $today || $event->end_date < $today) {
            return redirect()->back()->with('error', 'Attendance is not allowed outside the event dates.');
        }

        $attendanceExists = Attendance::where([
            ['event_id', $request->event_id],
            ['id_anggota', $user->id], // Correct ID reference
            ['attendance_date', $today],
        ])->exists();

        if ($attendanceExists) {
            return redirect()->back()->with('error', 'User already attended this event today.');
        }

        try {
            Attendance::create([
                'event_id' => $request->event_id,
                'id_anggota' => $user->id, // Always use the actual user ID
                'attendance_date' => $today,
            ]);

            return redirect()->route('events.attend', $request->event_id)
                ->with('success', 'Attendance recorded successfully!');
        } catch (\Exception $e) {
            \Log::error('Attendance Error:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to record attendance. Please try again.');
        }
    }


    public function getAttendance($event_id)
    {
        $event = Event::findOrFail($event_id);
        $attendances = Attendance::join('data_anggota', 'attendances.id_anggota', '=', 'data_anggota.id') // Join users table
            ->join('events', 'attendances.event_id', '=', 'events.id') // Join events table
            ->where('attendances.event_id', $event_id)
            ->select(
                'attendances.*', 
                'data_anggota.id as id_anggota',
                'data_anggota.Nama_Lengkap as nama_anggota',
                'data_anggota.Email as email_anggota',
                
            ) 
            ->orderBy('attendances.created_at', 'asc')
            ->paginate(15);
                
            // dd($attendances);
        return view('attendance.index', compact('attendances', 'event'));
    }


    public function downloadAttendanceCSV($event_id)
    {
        $event = Event::findOrFail($event_id);

        $attendances = Attendance::join('data_anggota', 'attendances.id_anggota', '=', 'data_anggota.id') // Join users table
            ->join('events', 'attendances.event_id', '=', 'events.id') // Join events table
            ->where('attendances.event_id', $event_id)
            ->select(
                'data_anggota.id as id_anggota',
                'data_anggota.Nama_Lengkap as nama_anggota',
                'data_anggota.Email as email_anggota',
                'attendances.created_at as attendance_date',
            ) 
            ->orderBy('attendances.created_at', 'asc')
            ->get();

        $csvHeaders = [
            'ID Anggota',
            'Nama Lengkap',
            'Email',
            'Attendance Date',
        ];

        $fileName = "absensi_event_{$event->name}.csv";

        $callback = function () use ($attendances, $csvHeaders) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $csvHeaders);

            foreach ($attendances as $attendance) {
                fputcsv($file, [
                    $attendance->id_anggota,
                    $attendance->nama_anggota,
                    $attendance->email_anggota,
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
