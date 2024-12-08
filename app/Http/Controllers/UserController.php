<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.home', compact('users'));
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
                'image' => '|image|mimes:jpeg,png,jpg', 
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
            ]);


            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('images', 'public');
                $validatedData['image_link'] = $path;
            }

            $user = User::create($validatedData);

            // Redirect with success message
            return redirect()->route('users.home')->with('success', 'User created successfully.');
       
    }

    public function show($idOrCardId)
    {
        // Find the user by either 'id' or 'card_id'
        $user = User::where('user_id', $idOrCardId)
                    ->orWhere('card_id', $idOrCardId)
                    ->firstOrFail();

        return view('users.show', compact('user'));
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
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'nama_lengkap' => 'sometimes|string|max:255',
            'jenis_kelamin' => 'sometimes|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'sometimes|date',
            'golongan_darah' => 'sometimes|string|max:3',
            'vihara' => 'sometimes|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image
            if ($user->image_link) {
                Storage::disk('public')->delete($user->image_link);
            }

            $path = $request->file('image')->store('images', 'public');
            $validatedData['image_link'] = $path;
        }

        $user->update($validatedData);

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
