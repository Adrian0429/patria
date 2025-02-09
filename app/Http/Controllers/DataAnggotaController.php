<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataAnggota;
use App\Models\DPD;
use App\Models\DPC;
use App\Models\InformasiAkses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class DataAnggotaController extends Controller
{
    
    public function index(Request $request)
    {   
        
        // Get the search term from the query parameter
        $search = $request->query('search');

        // Initialize the query
        $query = DataAnggota::query();
        
        if (auth()->user()->jabatan == 'DPD') {
            $query->where('dpd_id', '=', auth()->user()->dpd_id);
        } else if (auth()->user()->jabatan == 'DPC' || auth()->user()->jabatan == 'DPAC') {
            $query->where('dpc_id', '=', auth()->user()->dpc_id);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('Nama_Lengkap', 'LIKE', "%{$search}%")
                  ->orWhere('Email', 'LIKE', "%{$search}%")
                  ->orWhere('id', 'LIKE', "%{$search}%");
            });
        }

        // Join with DPD or DPC based on dpc_id or dpd_id
        $query->leftJoin('dpd', 'data_anggota.dpd_id', '=', 'dpd.id')
              ->leftJoin('dpc', 'data_anggota.dpc_id', '=', 'dpc.id')
              ->select('data_anggota.*', 'dpd.nama_dpd', 'dpc.nama_dpc');



        $anggotas = $query->paginate(10);

        return view('anggota.home', compact('anggotas', 'search'));
    }   
    
    public function detail($id)
    {
        $anggota = DataAnggota::where('data_anggota.id', $id)
            ->leftJoin('dpd', 'data_anggota.dpd_id', '=', 'dpd.id')
            ->leftJoin('dpc', 'data_anggota.dpc_id', '=', 'dpc.id')
            ->select('data_anggota.*', 'dpd.nama_dpd', 'dpc.nama_dpc')
            ->firstOrFail(); 

        return view('anggota.detail', compact('anggota'));
    }


    public function destroy($id)
    {
        $anggota = DataAnggota::findOrFail($id);

        if ($anggota->image_link) {
            Storage::disk('public')->delete($anggota->image_link);
        }

        $anggota->delete();

        return redirect()->route('anggota.home')->with('success', 'data deleted successfully.');
    }

    public function create()
    {
        $dpds = DPD::all();
        $dpcs = DPC::all();
        return view('anggota.make', compact('dpds', 'dpcs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ID_Kartu' => 'required|unique:data_anggota,ID_Kartu,',
            'NIK' => 'required|unique:data_anggota,NIK,',
            'Nama_Lengkap' => 'required',
            'Nama_Buddhis' => 'nullable',
            'Gelar_Akademis' => 'nullable',
            'Profesi' => 'nullable',
            'Email' => 'required|email',
            'No_HP' => 'required',
            'Jenis_Kelamin' => 'required|in:Laki-laki,Perempuan',
            'Alamat' => 'required',
            'Kota_Lahir' => 'required',
            'Tanggal_Lahir' => 'required|date',
            'Golongan_Darah' => 'nullable|in:A,B,AB,O',
            'img_link' => 'nullable',
            'Mengenal_Patria_Dari' => 'nullable',
            'Histori_Patria' => 'nullable',
            'Pernah_Mengikuti_PBT' => 'boolean',
            'dpd_id' => 'nullable|exists:dpd,id',
            'dpc_id' => 'nullable|exists:dpc,id',
            'nama_penginput' => 'required',
            'jabatan_penginput' => 'required',
            'Status_Kartu' => 'required|in:belum_cetak,sudah_cetak',
            'keterangan' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:6048',
        ]);

        if ($request->filled('dpd_id')) {
            $kodeWilayah = DPD::where('id', $request->dpd_id)->value('kode_daerah');
        } elseif ($request->filled('dpc_id')) {
            $kodeWilayah = DPC::where('id', $request->dpc_id)->value('kode_daerah');
        } else {
            return back()->withErrors(['dpd_id' => 'Kode wilayah tidak ditemukan.']);
        }

        // Get last 2 digits of the current year
        $tahun = date('y');

        // Get the latest Kode Registrasi for this region & year
        $lastEntry = DataAnggota::where('id', 'like', "$kodeWilayah$tahun%")
                                ->orderBy('id', 'desc')
                                ->first();

        $nextKode = $lastEntry ? (intval(substr($lastEntry->id, -4)) + 1) : 1;

        // Format the new ID_Kartu
        $id_anggota = sprintf("%s%s%04d", $kodeWilayah, $tahun, $nextKode);

        // Save the data
        $validated['id'] = $id_anggota;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $id_anggota . '.png';
            $image->storeAs('uploads/anggota', $filename, 'public');
        }

        // Set the `img_link` field to the expected filename, whether the image was uploaded or not
        $validated['img_link'] = 'uploads/anggota/' . $id_anggota . '.png';

        // Create DataAnggota
        $anggota = DataAnggota::create($validated);

        InformasiAkses::create([
            'type' => 'create',
            'user_id' => Auth::id(),
            'id_anggota' => $anggota->id,
            'keterangan' => $validated['keterangan'] ?? 'Data anggota baru ditambahkan',
            'nama_penginput' => $validated['nama_penginput'] ?? Auth::user()->name ?? 'Unknown',
            'jabatan_penginput' => $validated['jabatan_penginput'] ?? Auth::user()->role ?? 'Unknown',
            'created_at' => now(), // Manually set 'created_at'
        ]);

        return redirect()->route('anggota.home')->with('success', "Data anggota berhasil ditambahkan dengan ID $id_anggota");
    }

    public function edit($id)
    {
        $anggota = DataAnggota::findOrFail($id);
        $dpds = Dpd::all();
        $dpcs = Dpc::all();

        
        return view('anggota.edit', compact('anggota', 'dpds', 'dpcs'));
    }


    public function update(Request $request, $id)
    {
        $anggota = DataAnggota::findOrFail($id);
        $id_anggota = $anggota->id;
        $validated = $request->validate([
            'ID_Kartu' => "required|unique:data_anggota,ID_Kartu,$id,id",
            'NIK' => "required|unique:data_anggota,NIK,$id,id",
            'Nama_Lengkap' => 'required',
            'Nama_Buddhis' => 'nullable',
            'Gelar_Akademis' => 'nullable',
            'Profesi' => 'nullable',
            'Email' => 'required|email',
            'No_HP' => 'required',
            'Jenis_Kelamin' => 'required|in:Laki-laki,Perempuan',
            'Alamat' => 'required',
            'Kota_Lahir' => 'required',
            'Tanggal_Lahir' => 'required|date',
            'Golongan_Darah' => 'nullable|in:A,B,AB,O',
            'img_link' => 'nullable',
            'Mengenal_Patria_Dari' => 'nullable',
            'Histori_Patria' => 'nullable',
            'Pernah_Mengikuti_PBT' => 'boolean',
            'dpd_id' => 'nullable|exists:dpd,id',
            'dpc_id' => 'nullable|exists:dpc,id',
            'nama_penginput' => 'required',
            'jabatan_penginput' => 'required',
            'Status_Kartu' => 'required|in:belum_cetak,sudah_cetak',
            'keterangan' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:6048',
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            $filename = $id_anggota . '.png';
            $imagePath = 'uploads/anggota/' . $filename;

            // Delete the old image if it exists
            if ($anggota->img_link && Storage::disk('public')->exists($anggota->img_link)) {
                Storage::disk('public')->delete($anggota->img_link);
            }

            // Store the new image with the specific filename
            $request->file('image')->storeAs('uploads/anggota', $filename, 'public');

            // Update the img_link field
            $validated['img_link'] = $imagePath;
        } else {
            // Ensure img_link is still set correctly even if no new image is uploaded
            $validated['img_link'] = 'uploads/anggota/' . $id_anggota . '.png';
        }


        // Update DataAnggota
        $anggota->update($validated);

        // Log InformasiAkses update
        InformasiAkses::create([
            'type' => 'update',
            'user_id' => Auth::id(),
            'id_anggota' => $anggota->id,
            'keterangan' => $validated['keterangan'] ?? 'Update Data anggota',
            'nama_penginput' => $validated['nama_penginput'] ?? Auth::user()->name ?? 'Unknown',
            'jabatan_penginput' => $validated['jabatan_penginput'] ?? Auth::user()->role ?? 'Unknown',
            'created_at' => now(), 
        ]);

        return redirect()->route('anggota.home')->with('success', "Data anggota berhasil diperbarui.");
    }

    public function exportCSV()
    {
        $fileName = 'data_anggota.csv';

        // Fetch all anggota data with related DPD/DPC
        $anggota = DataAnggota::leftJoin('dpd', 'data_anggota.dpd_id', '=', 'dpd.id')
            ->leftJoin('dpc', 'data_anggota.dpc_id', '=', 'dpc.id')
            ->select(
                'data_anggota.ID_Kartu',
                'data_anggota.NIK',
                'data_anggota.Nama_Lengkap',
                'data_anggota.Nama_Buddhis',
                'data_anggota.Jenis_Kelamin',
                'data_anggota.Kota_Lahir',
                'data_anggota.Tanggal_Lahir',
                'data_anggota.Golongan_Darah',
                'data_anggota.Gelar_Akademis',
                'data_anggota.Profesi',
                'data_anggota.Email',
                'data_anggota.No_HP',
                'data_anggota.Alamat',
                'data_anggota.Status_Kartu',
                'data_anggota.Mengenal_Patria_Dari',
                'data_anggota.Histori_Patria',
                'data_anggota.Pernah_Mengikuti_PBT',
                'dpd.nama_dpd AS Nama_DPD',
                'dpd.kode_daerah AS Kode_DPD',
                'dpc.nama_dpc AS Nama_DPC',
                'dpc.kode_daerah AS Kode_DPC',
                'data_anggota.created_at'
            )
            ->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($anggota) {
            $file = fopen('php://output', 'w');

            // Add CSV header row
            fputcsv($file, [
                'ID Kartu', 'NIK', 'Nama Lengkap', 'Nama Buddhis', 'Jenis Kelamin',
                'Kota Lahir', 'Tanggal Lahir', 'Golongan Darah', 'Gelar Akademis', 
                'Profesi', 'Email', 'No HP', 'Alamat', 'Status Kartu', 
                'Mengenal Patria Dari', 'Histori Patria', 'Pernah Mengikuti PBT',
                'Nama DPD', 'Kode DPD', 'Nama DPC', 'Kode DPC', 'Created At'
            ]);

            // Add each anggota row to CSV
            foreach ($anggota as $row) {
                fputcsv($file, [
                    $row->ID_Kartu,
                    $row->NIK,
                    $row->Nama_Lengkap,
                    $row->Nama_Buddhis,
                    $row->Jenis_Kelamin,
                    $row->Kota_Lahir,
                    $row->Tanggal_Lahir,
                    $row->Golongan_Darah,
                    $row->Gelar_Akademis,
                    $row->Profesi,
                    $row->Email,
                    $row->No_HP,
                    $row->Alamat,
                    $row->Status_Kartu,
                    $row->Mengenal_Patria_Dari,
                    $row->Histori_Patria,
                    $row->Pernah_Mengikuti_PBT ? 'Ya' : 'Tidak',
                    $row->Nama_DPD ?: '-',
                    $row->Kode_DPD ?: '-',
                    $row->Nama_DPC ?: '-',
                    $row->Kode_DPC ?: '-',
                    $row->created_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

        
    public function uploadimage(Request $request)
    {   
        $request->validate([
            'photos.*' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Added max size validation
        ]);

        $uploadedPaths = [];

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $imageName = time() . '_' . $file->getClientOriginalName(); // Add timestamp to prevent overwriting
                $path = $file->storeAs('images', $imageName, 'public');
                $uploadedPaths[] = $path;
            }

            return redirect()->back()->with('success', 'Images uploaded successfully!');
        }

        return redirect()->back()->with('error', 'No images were uploaded.');
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
