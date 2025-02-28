<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PindahDaerah;
use App\Models\DataAnggota;
use Illuminate\Support\Facades\Auth;

class PindahDaerahController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userDpc = $user->dpc_id;

        if ($user->jabatan == 'admin') {
            $pindahDaerah = PindahDaerah::with(['dataAnggota', 'asalDpc', 'keDpc'])->paginate(10);
        } else {
            $pindahDaerah = PindahDaerah::with(['dataAnggota', 'asalDpc', 'keDpc'])
                ->where('asal_dpc', $userDpc)
                ->orWhere('ke_dpc', $userDpc)
                ->paginate(10);
        }

        return view('pindah_daerah.index', compact('pindahDaerah'));
    }

    // Menyimpan permohonan pindah daerah
    public function store(Request $request)
    {
        $request->validate([
            'id_anggota' => 'required|exists:data_anggota,id',
            'asal_dpc' => 'required|exists:dpc,id',
            'ke_dpc' => 'required|exists:dpc,id',
        ]);

        // Check if id_anggota already exists in PindahDaerah
        $existingPindah = PindahDaerah::where('id_anggota', $request->id_anggota)->first();
        if ($existingPindah) {
            return back()->with('error', 'Permohonan pindah daerah untuk anggota ini sudah ada.');
        }

        PindahDaerah::create([
            'id_anggota' => $request->id_anggota,
            'asal_dpc' => $request->asal_dpc,
            'ke_dpc' => $request->ke_dpc,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Permohonan pindah daerah berhasil disimpan.');
    }

    // Menerima permohonan pindah daerah
    public function accept($id)
    {
        $pindah = PindahDaerah::findOrFail($id);

        // Update data anggota untuk pindah ke DPC baru
        $anggota = DataAnggota::find($pindah->id_anggota);
        if ($anggota) {
            $anggota->dpc_id = $pindah->ke_dpc;
            $anggota->save();
        }

        $pindah->delete();

        return redirect()->route('pindah_daerah.index')->with('success', 'Permohonan pindah daerah telah diterima.');
    }

    // Menolak permohonan pindah daerah
    public function reject($id)
    {
        $pindah = PindahDaerah::findOrFail($id);
        $pindah->delete();

        return redirect()->route('pindah_daerah.index')->with('success', 'Permohonan pindah daerah telah ditolak.');
    }
}
