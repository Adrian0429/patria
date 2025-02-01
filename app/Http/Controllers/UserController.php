<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    
    public function index(Request $request)
    {
        // Get the search term from the query parameter
        $search = $request->query('search');

        // Initialize the query
        $query = User::where('user_id', '!=', 'admin1234');

        if (auth()->user()->role == 'admin' || auth()->user()->role == 'DPP') {
            // No additional filters needed for admin or DPP
        } else if (auth()->user()->role == 'DPD') {
            $query->where('role', '!=', 'DPP')->where('daerah', '=', auth()->user()->daerah);
        } else if (auth()->user()->role == 'DPC') {
            $query->where('role', '!=', 'DPP')
                ->where('role', '!=', 'DPD')
                ->where('daerah', '=', auth()->user()->daerah);
        } else if (auth()->user()->role == 'DPAC') {
            $query->where('role', '!=', 'DPP')
                ->where('role', '!=', 'DPD')
                ->where('role', '!=', 'DPC')
                ->where('daerah', '=', auth()->user()->daerah);
        } else {
            return view('users.profile');
        }

        // Apply search filter if a search term is provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('user_id', 'LIKE', "%{$search}%");
            });
        }

        // Paginate the results
        $users = $query->paginate(10);

        return view('users.home', compact('users', 'search'));
    }


    public function profile()
    {   
        if (!auth()->check() || auth()->user()->user_id === null) {
            return redirect()->route('login');
        }

        $id = auth()->user()->user_id;
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.create'); 
    }

    public function storeCSV(Request $request)
    {
        $validated = $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');

        // Open the file for reading
        $handle = fopen($file->getRealPath(), 'r');
  
        $data = [];
        $isFirstRow = true; // Flag to identify the first row

        // Read through the file line by line and use semicolon as delimiter
        while (($row = fgetcsv($handle, 1000, ';')) !== false) {
            // Skip the first row (header)
            if ($isFirstRow) {
                $isFirstRow = false;
                continue;
            }

            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            $data[] = $row;
        }

        fclose($handle);

        // Process each row from CSV
        foreach ($data as $row) {
            User::create([
                'card_id' => $row[0] ?? null,
                'user_id' => $row[1],
                'nama_lengkap' => $row[2],
                'jenis_kelamin' => $row[3],
                'tanggal_lahir' => \Carbon\Carbon::createFromFormat('d/m/y', $row[4])->format('Y-m-d'),
                'golongan_darah' => $row[5],
                'vihara' => $row[6],
                'email' => $row[7] ?? null,
                'role' => $row[8],
                'password' => bcrypt($row[9]),
                'daerah' => $row[10],
                'image_link' => $row[1] . '.png',
            ]);
        }

        return redirect()->route('users.home')->with('success', 'Users added successfully via CSV!');
    }


    public function store(Request $request)
    {
            // Validate and process manual input
            $validated = $request->validate([
                'card_id' => 'nullable|string|max:255',
                'user_id' => 'required|string|max:255',
                'nama_lengkap' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'password' => 'required|string|min:8',
                'jenis_kelamin' => 'required|string',
                'tanggal_lahir' => 'required|date',
                'golongan_darah' => 'nullable|string',
                'role' => 'required|string',
                'vihara' => 'required|string|max:255',
                'daerah' => 'required|string|max:255',
            ]);

            if ($request->hasFile('image')) {
                $extension = $request->file('image')->getClientOriginalExtension();
                $imageName = $validated['user_id'] . '.' . $extension;

                $path = $request->file('image')->storeAs('images', $imageName, 'public');
                $validated['image_link'] = $path;
            } else {
                $validated['image_link'] = 'images/' + $validated['user_id'] + '.png';
            }

            $validated['password'] = bcrypt($validated['password']);

            User::create($validated);

            return redirect()->route('users.home')->with('success', 'User added successfully!');
        
    }

    public function uploadimage(Request $request)
    {   
        $request->validate([
            'photos.*' => 'required|image|mimes:jpeg,png,jpg', // Validate each image
        ]);

        $uploadedPaths = [];

        // Check if there are any files to upload
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                // Get the original filename (assuming it's already formatted as userid.extension)
                $imageName = $file->getClientOriginalName();

                // Save the file in the 'images' directory in public storage
                $path = $file->storeAs('images', $imageName, 'public');

                // Store the file path
                $uploadedPaths[] = $path;
            }
        }
    }

    public function show($idOrCardId)
    {
        try {
            $user = User::where('user_id', $idOrCardId)
                        ->orWhere('card_id', $idOrCardId)
                        ->firstOrFail();

            return view('users.show', compact('user'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'User not found. Please try again.');
        }
    }


    public function search(Request $request)
    {
        $validatedData = $request->validate([
            'userId' => 'required|integer|exists:users,user_id',
        ]);

        return redirect()->route('users.show', $validatedData['userId']);
    }

    public function edit($id)
    {   
        if (Auth::user()->user_id != $id && Auth::user()->role == 'Anggota') {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }

        $user = User::findOrFail($id);
        // dd($user);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validatedData = $request->validate([
                'card_id' => 'nullable|string|max:20',
                'user_id' => 'nullable|string|max:20',
                'nama_lengkap' => 'nullable|string|max:255',
                'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
                'tanggal_lahir' => 'nullable|date',
                'golongan_darah' => 'nullable|string|max:3',
                'vihara' => 'nullable|string|max:255',
                'daerah' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg',
                'email' => 'nullable|email|unique:users,email,' . $id . ',user_id',
                'role' => 'nullable|in:admin,DPP,DPC,Anggota',
                'password' => 'nullable|string',
            ]);

            if ($request->hasFile('image')) {
                // Delete the old image if exists
                if ($user->image_link) {
                    Storage::disk('public')->delete($user->image_link);
                }

                $extension = $request->file('image')->getClientOriginalExtension(); 
                $imageName = $user->user_id . '.' . $extension;

                $path = $request->file('image')->storeAs('images', $imageName, 'public');
                $validatedData['image_link'] = $path;
            }

            if ($request->filled('password')) {
                $validatedData['password'] = bcrypt($request->input('password'));
            }

            // Filter out null values
            $filteredData = array_filter($validatedData, function ($value) {
                return $value !== null;
            });

            $user->update($filteredData);

            return redirect()->route('users.home')->with('success', 'User updated successfully.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'User not found.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Validation failed. Please check your input.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->image_link) {
            Storage::disk('public')->delete($user->image_link);
        }

        $user->delete();

        return redirect()->route('users.home')->with('success', 'User deleted successfully.');
    }

    public function downloadTemplate()
    {
        $headers = [
            'card_id', 'user_id', 'nama_lengkap', 'jenis_kelamin',
            'tanggal_lahir', 'golongan_darah', 'vihara',
            'email', 'role', 'password', 'daerah'
        ];

 
        $exampleRow = [
            '12345', 'USR001', 'John Doe', 'Laki-laki',
            '1990-01-01', 'A', 'Buddhist Temple',
            'johndoe@example.com', 'admin', 'password123', 'Jakarta'
        ];

        $csvContent = implode(';', $headers) . "\n" . implode(';', $exampleRow);

        $filename = "template_tambah_anggota.csv";

        // Return the CSV as a download
        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ]);
    }

    
}
