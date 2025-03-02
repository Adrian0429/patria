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
        $search = $request->query('search');
        $query = DataAnggota::query()
            ->leftJoin('dpd', 'data_anggota.dpd_id', '=', 'dpd.id')
            ->leftJoin('dpc', 'data_anggota.dpc_id', '=', 'dpc.id')
            ->select('data_anggota.*', 'dpd.nama_dpd', 'dpc.nama_dpc');

        // Filtering based on user role
        if (auth()->user()->jabatan == 'DPD') {
            // Get all DPC IDs under the user's DPD
            $dpcIds = Dpc::where('dpd_id', auth()->user()->dpd_id)->pluck('id')->toArray();

            // Retrieve data_anggota belonging to either DPD or DPC
            $query->where(function ($q) use ($dpcIds) {
                $q->where('data_anggota.dpd_id', auth()->user()->dpd_id)
                ->orWhereIn('data_anggota.dpc_id', $dpcIds);
            });
        } elseif (auth()->user()->jabatan == 'DPC' || auth()->user()->jabatan == 'DPAC') {
            $query->where('data_anggota.dpc_id', auth()->user()->dpc_id);
        }

        // Search functionality
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('Nama_Lengkap', 'LIKE', "%{$search}%")
                ->orWhere('Email', 'LIKE', "%{$search}%")
                ->orWhere('data_anggota.id', 'LIKE', "%{$search}%")
                ->orWhere('ID_Kartu', 'LIKE', "%{$search}%")
                ->orWhere('NIK', 'LIKE', "%{$search}%")
                ->orWhere('dpd.nama_dpd', 'LIKE', "%{$search}%")
                ->orWhere('dpc.nama_dpc', 'LIKE', "%{$search}%");
            });
        }

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
        
        $dpc = DPC::all();

        return view('anggota.detail', compact('anggota', 'dpc'));
    }

    public function destroy($id)
    {
        $anggota = DataAnggota::findOrFail($id);

        if ($anggota->image_link) {
            Storage::disk('public')->delete($anggota->image_link);
        }

        InformasiAkses::create([
            'type' => 'delete',
            'user_id' => Auth::id(),
            'keterangan' => 'Data anggota ' . $anggota->id . ' dihapus',
            'nama_penginput' => Auth::user()->name ?? 'Unknown',
            'jabatan_penginput' => Auth::user()->jabatan ?? 'Unknown',
            'created_at' => now(), // Manually set 'created_at'
        ]);

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
            'keterangan' => $validated['keterangan'] ?? 'Data anggota baru ditambahkan dengan id ' . $anggota->id,
            'nama_penginput' => $validated['nama_penginput'] ?? Auth::user()->name ?? 'Unknown',
            'jabatan_penginput' => $validated['jabatan_penginput'] ?? Auth::user()->jabatan ?? 'Unknown',
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
            'keterangan' => $validated['keterangan'] ?? 'Update Data anggota' . $id_anggota,
            'nama_penginput' => $validated['nama_penginput'] ?? Auth::user()->name ?? 'Unknown',
            'jabatan_penginput' => $validated['jabatan_penginput'] ?? Auth::user()->jabatan ?? 'Unknown',
            'created_at' => now(), 
        ]);

        return redirect()->route('anggota.home')->with('success', "Data anggota berhasil diperbarui.");
    }

    public function exportCSV()
    {

        $fileName = 'data_anggota.csv';
        // Fetch all anggota data with related DPD/DPC
        $query = DataAnggota::leftJoin('dpd', 'data_anggota.dpd_id', '=', 'dpd.id')
            ->leftJoin('dpc', 'data_anggota.dpc_id', '=', 'dpc.id')
            ->select(
                'data_anggota.id',
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
                'data_anggota.dpd_id',
                'data_anggota.dpc_id',
                'data_anggota.created_at'
            );

        // Filtering based on user role
        if (auth()->user()->jabatan == 'DPD') {
            // Get all DPC IDs under the user's DPD
            $dpcIds = Dpc::where('dpd_id', auth()->user()->dpd_id)->pluck('id')->toArray();

            // Retrieve data_anggota belonging to either DPD or DPC
            $query->where(function ($q) use ($dpcIds) {
                $q->where('data_anggota.dpd_id', auth()->user()->dpd_id)
                ->orWhereIn('data_anggota.dpc_id', $dpcIds);
            });
        } elseif (auth()->user()->jabatan == 'DPC' || auth()->user()->jabatan == 'DPAC') {
            $query->where('data_anggota.dpc_id', auth()->user()->dpc_id);
        }


        $anggota = $query->get(); 

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
                'ID Anggota','ID Kartu', 'NIK', 'Nama Lengkap', 'Nama Buddhis', 'Jenis Kelamin',
                'Kota Lahir', 'Tanggal Lahir', 'Golongan Darah', 'Gelar Akademis', 
                'Profesi', 'Email', 'No HP', 'Alamat', 'Status Kartu', 
                'Mengenal Patria Dari', 'Histori Patria', 'Pernah Mengikuti PBT',
                'Nama DPD', 'Kode DPD', 'Nama DPC', 'Kode DPC', 'Created At'
            ]);

            // Add each anggota row to CSV
            foreach ($anggota as $row) {
                fputcsv($file, [
                    $row->id,
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


    public function show($idOrCardId)
    {
        try {
            $anggota = DataAnggota::where('id', $idOrCardId)
                        ->orWhere('ID_Kartu', $idOrCardId)
                        ->firstOrFail();

            return view('anggota.show', compact('anggota'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'User not found. Please try again.');
        }
    }
                
    public function uploadImage(Request $request)
    {
        if (!$request->hasFile('images')) {
            return redirect()->back()->with('error', 'No files received!');
        }

        $uploadedPaths = [];

        foreach ($request->file('images') as $image) {
            if (!$image->isValid()) {
                return redirect()->back()->with('error', 'File upload failed!');
            }

            $filename = $image->getClientOriginalName();
            $storagePath = "uploads/anggota/$filename";

            // Delete old file if exists
            if (Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->delete($storagePath);
            }

            // Store new file
            $path = $image->storeAs('uploads/anggota', $filename, 'public');
            $uploadedPaths[] = $path;
        }

        return redirect()->back()->with('success', 'Images uploaded successfully!');
    }

    // public function search(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'userId' => 'required|integer|exists:users,user_id',
    //     ]);

    //     return redirect()->route('users.show', $validatedData['userId']);
    // }
        
    public function template()
    {
        $headers = [
            'ID_Kartu (kosongkan saja apabila tidak perlu)', 'NIK', 'Nama_Lengkap', 'Nama_Buddhis', 'Gelar_Akademis', 'Profesi',
            'Email', 'No_HP', 'Jenis_Kelamin', 'Alamat', 'Kota_Lahir', 'Tanggal_Lahir',
            'Golongan_Darah', 'img_link (biarkan kosong)', 'Status_Kartu', 'Mengenal_Patria_Dari', 'Histori_Patria',
            'Pernah_Mengikuti_PBT', 'kode_dpd(lihat dari data dpd)', 'kode_dpc(lihat dari data dpc)'
        ];

        $exampleRow1 = [
            '', '1234567890123456', 'Jane Doe', 'Nama Buddhis', 'S.Kom', 'Software Engineer',
            'johndoe@example.com', '08123456789', 'Laki-Laki', 'Jl. Contoh No. 123', 'Jakarta', '1990-01-01',
            'A', '', 'belum_cetak', 'Teman', 'Pernah ikut acara', '1', '12', ''
        ];

        $exampleRow2 = [
            '', '9876543210987654', 'Jane Smith', 'Nama Buddhis 2', 'M.M', 'Data Analyst',
            'aniwijaya@example.com', '081298765432', 'Perempuan', 'Jl. Contoh No. 456', 'Bandung', '1995-05-15',
            'B', '', 'sudah_cetak', 'Sosial Media', 'Ikut kegiatan', '0', '', '1201'
        ];

        // Convert array to CSV format
        $csvContent = implode(';', $headers) . "\n" .
                    implode(';', $exampleRow1) . "\n" .
                    implode(';', $exampleRow2);

        $filename = "template_tambah_anggota.csv";

        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ]);
    }

    public function importCSV(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');

        if (!$handle) {
            return back()->withErrors(['file' => 'Gagal membaca file.']);
        }

        $headers = fgetcsv($handle, 1000, ';'); // Read the header row
        $expectedHeaders = [
            'ID_Kartu (kosongkan saja apabila tidak perlu)', 'NIK', 'Nama_Lengkap', 'Nama_Buddhis', 'Gelar_Akademis', 'Profesi',
            'Email', 'No_HP', 'Jenis_Kelamin', 'Alamat', 'Kota_Lahir', 'Tanggal_Lahir',
            'Golongan_Darah', 'img_link (biarkan kosong)','Status_Kartu', 'Mengenal_Patria_Dari', 'Histori_Patria',
            'Pernah_Mengikuti_PBT', 'kode_dpd(lihat dari data dpd)', 'kode_dpc(lihat dari data dpc)'
        ];

        if ($headers !== $expectedHeaders) {
            return back()->withErrors(['file' => 'Format CSV tidak sesuai.']);
        }
        // dd($headers);

        $dataToInsert = [];
        $now = now();
        // dd($file);
        while (($row = fgetcsv($handle, 1000, ';')) !== false) {
            $dpd_id = !empty($row[18]) ? DPD::where('kode_daerah', $row[18])->value('id') : null;
            $dpc_id = !empty($row[19]) ? DPC::where('kode_daerah', $row[19])->value('id') : null;

            if (!$dpd_id && !$dpc_id) {
                continue; // Skip if neither dpd_id nor dpc_id is provided
            }

            // Generate ID_Kartu
            $kodeWilayah = $dpd_id ? DPD::where('id', $dpd_id)->value('kode_daerah') : DPC::where('id', $dpc_id)->value('kode_daerah');
            $tahun = date('y');
            $lastEntry = DataAnggota::where('id', 'like', "$kodeWilayah$tahun%")
                                    ->orderBy('id', 'desc')
                                    ->first();
            $nextKode = $lastEntry ? (intval(substr($lastEntry->id, -4)) + 1) : 1;
            $id_anggota = sprintf("%s%s%04d", $kodeWilayah, $tahun, $nextKode);


            $tanggalLahir = null;
            if (!empty($row[11])) {
                $tanggalLahir = \DateTime::createFromFormat('d/m/y', $row[11]) 
                    ?: \DateTime::createFromFormat('d/m/Y', $row[11]) 
                    ?: \DateTime::createFromFormat('Y-m-d', $row[11]); // Added support for 'Y-m-d'

                if ($tanggalLahir) {
                    $tanggalLahir = $tanggalLahir->format('Y-m-d'); // Convert to MySQL format
                } else {
                    return back()->withErrors(['file' => 'Format tanggal lahir tidak valid pada baris: ' . json_encode($row)]);
                }
            }

            $dataToInsert[] = [
                'id' => $id_anggota,
                'ID_Kartu' => $row[0],
                'NIK' => $row[1] ?? null,
                'Nama_Lengkap' => $row[2] ?? null,
                'Nama_Buddhis' => $row[3] ?? null,
                'Gelar_Akademis' => $row[4] ?? null,
                'Profesi' => $row[5] ?? null,
                'Email' => $row[6] ?? null,
                'No_HP' => $row[7] ?? null,
                'Jenis_Kelamin' => $row[8] ?? null,
                'Alamat' => $row[9] ?? null,
                'Kota_Lahir' => $row[10] ?? null,
                'Tanggal_Lahir' => $tanggalLahir,
                'Golongan_Darah' => $row[12] ?? null,
                'Status_Kartu' => $row[14] ?? null,
                'Mengenal_Patria_Dari' => $row[15] ?? null,
                'Histori_Patria' => $row[16] ?? null,
                'img_link'=> 'uploads/anggota/' . $id_anggota . '.png',
                'Pernah_Mengikuti_PBT' => filter_var($row[17], FILTER_VALIDATE_BOOLEAN),
                'dpd_id' => $dpd_id,
                'dpc_id' => $dpc_id,
            ];
        }

        fclose($handle);

        if (!empty($dataToInsert)) {
            foreach ($dataToInsert as $data) {
                $anggota = DataAnggota::create($data);

                InformasiAkses::create([
                    'type' => 'create',
                    'user_id' => Auth::id(),
                    'keterangan' => $request->keterangan . ' anggota id ' . $anggota->id ?? 'Data anggota baru ditambahkan (upload csv) ' . $anggota->id,
                    'nama_penginput' => $request->nama_penginput ?? Auth::user()->name ?? 'Unknown',
                    'jabatan_penginput' => $request->jabatan_penginput ?? Auth::user()->jabatan ?? 'Unknown',
                    'created_at' => now(),
                ]);
            }
            return back()->with('success', count($dataToInsert) . ' anggota berhasil diimport.');
        }

        return back()->withErrors(['file' => 'Tidak ada data yang dapat diimport.']);
    }

    
    public function exportDPDCSV()
    {
        $fileName = 'data_dpd.csv';
        
        $dpdData = DPD::select('id', 'nama_dpd', 'kode_daerah', 'created_at')->get();
        
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        
        $callback = function() use ($dpdData) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['ID', 'Nama DPD', 'Kode Daerah', 'Created At']);
            
            foreach ($dpdData as $row) {
                fputcsv($file, [
                    $row->id,
                    $row->nama_dpd,
                    $row->kode_daerah,
                    $row->created_at
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function exportDPCCSV()
    {
        $fileName = 'data_dpc.csv';
        
        $dpcData = DPC::leftJoin('dpd', 'dpc.dpd_id', '=', 'dpd.id')
            ->select('dpc.id', 'dpc.nama_dpc', 'dpc.kode_daerah', 'dpd.nama_dpd AS Nama_DPD', 'dpc.created_at')
            ->get();
        
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        
        $callback = function() use ($dpcData) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['ID', 'Nama DPC', 'Kode Daerah', 'Nama DPD', 'Created At']);
            
            foreach ($dpcData as $row) {
                fputcsv($file, [
                    $row->id,
                    $row->nama_dpc,
                    $row->kode_daerah,
                    $row->Nama_DPD,
                    $row->created_at
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    

}


