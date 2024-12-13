<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        if(auth()->user()->role == 'admin') {
            $users = User::where('user_id', '!=', 'admin1234')->paginate(10);
        }
        else if(auth()->user()->role == 'DPP') {
            $users = User::where('user_id', '!=', 'admin1234')->paginate(10);
        } else if(auth()->user()->role == 'DPC') {
            $users = User::where('user_id', '!=', 'admin1234')->where('role', '!=', 'DPP')->paginate(10);
        } else {
            return view('users.profile');
        }

        return view('users.home', compact('users'));
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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'card_id' => 'nullable|string|unique:users,card_id|max:20',
            'user_id' => 'required|string|unique:users,user_id|max:20',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'golongan_darah' => 'required|string|max:3',
            'vihara' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,DPP,DPC,Anggota',
            'password' => 'required|string|min:8',
        ]);

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension(); // Get file extension
            $imageName = $validatedData['user_id'] . '.' . $extension; // Use user_id as the filename

            $path = $request->file('image')->storeAs('images', $imageName, 'public');
            $validatedData['image_link'] = $path;
        }

        $validatedData['password'] = bcrypt($validatedData['password']);

        $user = User::create($validatedData);

        return redirect()->route('users.home')->with('success', 'User created successfully.');
    }

    public function show($idOrCardId)
    {
        try {
            $user = User::where('user_id', $idOrCardId)
                        ->orWhere('card_id', $idOrCardId)
                        ->firstOrFail();
                        
            return view('users.show', compact('user'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Redirect back with an error message
            return redirect()->back()->with('error', 'User not found.');
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
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'card_id' => 'nullable|string|max:20',
            'user_id' => 'nullable|string|max:20',
            'nama_lengkap' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'nullable|date',
            'golongan_darah' => 'nullable|string|max:3',
            'vihara' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'email' => 'nullable|email|unique:users,email,' . $id . ',user_id',
            'role' => 'nullable|in:admin,DPP,DPC,Anggota',
            'password' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($user->image_link) {
                Storage::disk('public')->delete($user->image_link);
            }

            $extension = $request->file('image')->getClientOriginalExtension(); // Get file extension
            $imageName = $user->user_id . '.' . $extension; // Use user_id as the filename

            // Store the image in the 'images' directory with the desired name
            $path = $request->file('image')->storeAs('images', $imageName, 'public');
            $validatedData['image_link'] = $path;
        }

        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($request->input('password'));
        }

        $filteredData = array_filter($validatedData, function ($value) {
            return $value !== null;
        });

        $user->update($filteredData);

        return redirect()->route('users.home')->with('success', 'User updated successfully.');
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
}
