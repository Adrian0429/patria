<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DPD;
use App\Models\DPC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{

    public function index_dpd(Request $request)
    {   
        $search = $request->input('search');

        $dpds = 
        DPD::query()->when($search, function ($query, $search) {
                        return $query->where('nama_dpd', 'like', "%{$search}%");
                    })->paginate(10);
        
        // Pass the users with their DPD and DPC information to the view
        return view('users.dpd', compact('dpds'));
    }

    public function store_dpd(Request $request)
    {
        $request->validate([
            'nama_dpd' => 'required|string|max:255',
            'kode_daerah' => 'required|string|max:50',
        ]);

        DPD::create($request->all());
        return redirect()->route('users.index_dpd')->with('success', 'DPD berhasil ditambahkan.');
    }

    /**
     * Update the specified DPP in storage.
     */
    public function update_dpd(Request $request, $id)
    {
        $request->validate([
            'nama_dpd' => 'required|string|max:255',
            'kode_daerah' => 'required|string|max:50',
        ]);

        $dpp = DPD::findOrFail($id);
        $dpp->update($request->all());

        return redirect()->route('users.index_dpd')->with('success', 'DPD berhasil dirubah.');
    }

    /**
     * Remove the specified DPP from storage.
     */
    public function destroy_dpd($id)
    {
        $dpp = DPD::findOrFail($id);
        $dpp->delete();

        return redirect()->route('users.index_dpd')->with('success', 'DPC berhasil dihapus.');
    }

    public function index_dpc(Request $request)
    {
        $search = $request->input('search');

        $dpcs = DPC::leftJoin('dpd', 'dpc.dpd_id', '=', 'dpd.id')
                    ->select('dpc.*', 'dpd.id as dpd_id', 'dpd.nama_dpd')
                    ->when($search, function ($query, $search) {
                        return $query->where('nama_dpc', 'like', "%{$search}%");
                    })
                    ->paginate(10);
        $dpds = DPD::all(); 

        return view('users.dpc', compact('dpcs', 'dpds'));
    }

    public function store_dpc(Request $request)
    {

        $request->validate([
            'dpd_id' => 'required|exists:dpd,id', // Ensure dpd_id exists
            'nama_dpc' => 'required|string|max:255',
            'kode_daerah' => 'required|string|max:50',
        ]);

        DPC::create($request->all());

        return redirect()->route('users.index_dpc')->with('success', 'DPC berhasil ditambahkan.');
    }

        /**
     * Update the specified DPC in storage.
     */
    public function update_dpc(Request $request, $id)
    {
        $request->validate([
            'dpd_id' => 'required|exists:dpd,id',
            'nama_dpc' => 'required|string|max:255',
            'kode_daerah' => 'required|string|max:50',
        ]);

        $dpc = DPC::findOrFail($id);
        $dpc->update($request->all());

        return redirect()->route('users.index_dpc')->with('success', 'DPC berhasil diperbarui.');
    }

    public function destroy_dpc($id)
    {
        $dpc = DPC::findOrFail($id);
        $dpc->delete();

        return redirect()->route('users.index_dpc')->with('success', 'DPC berhasil dihapus.');
    }


    public function index(Request $request)
    {
        $search = $request->input('search');

        // Join the User model with DPD and DPC based on dpd_id or dpc_id
        $users = User::leftJoin('dpd', 'users.dpd_id', '=', 'dpd.id')
                    ->leftJoin('dpc', 'users.dpc_id', '=', 'dpc.id')
                    ->select('users.*', 'dpd.nama_dpd', 'dpc.nama_dpc')  // Add necessary columns
                    ->when($search, function ($query, $search) {
                        return $query->where('users.nama', 'like', "%{$search}%")
                                     ->orWhere('users.email', 'like', "%{$search}%");
                    })
                    ->paginate(10);

        // Fetch all DPDs to pass to the view
        $dpds = DPD::all();
        $dpcs = DPC::all();
        // Pass the users with their DPD and DPC information to the view
        return view('users.home', compact('users', 'dpds', 'dpcs', 'search'));
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->all();

        // Convert empty string values to null
        $data['dpd_id'] = $data['dpd_id'] === "" ? null : $data['dpd_id'];
        $data['dpc_id'] = $data['dpc_id'] === "" ? null : $data['dpc_id'];

        $validatedData = Validator::make($data, [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id, // Ignore current user in unique validation
            'password' => 'nullable|min:6', // Password is not required on update
            'jabatan' => 'required|in:admin,DPP,DPD,DPC,DPAC',
            'dpd_id' => 'nullable|exists:dpd,id',
            'dpc_id' => 'nullable|exists:dpc,id',
        ])->validate();

        // Update user data
        $user->update([
            'nama' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'jabatan' => $validatedData['jabatan'],
            'dpd_id' => $validatedData['dpd_id'],
            'dpc_id' => $validatedData['dpc_id'],
            'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : $user->password, // Only update if new password is provided
        ]);

        return redirect()->route('users.home')->with('success', 'User updated successfully.');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.home')->with('success', 'User deleted successfully.');
    }

    
}
