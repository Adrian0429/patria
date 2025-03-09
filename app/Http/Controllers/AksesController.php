<?php

namespace App\Http\Controllers;

use App\Models\InformasiAkses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AksesController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = InformasiAkses::query()
            ->join('users', 'informasi_akses.user_id', '=', 'users.id')
            ->select('informasi_akses.*', 'users.*');

        // Search functionality
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('informasi_akses.user_id', 'LIKE', "%{$search}%")
                  ->orWhere('informasi_akses.nama_penginput', 'LIKE', "%{$search}%")
                  ->orWhere('informasi_akses.jabatan_penginput', 'LIKE', "%{$search}%")
                  ->orWhere('informasi_akses.keterangan', 'LIKE', "%{$search}%")
                  ->orWhere('informasi_akses.created_at', 'LIKE', "%{$search}%");
            });
        }

        $aksess = $query->orderBy('informasi_akses.created_at', 'desc')->paginate(10);

        return view('akses.home', compact('aksess', 'search'));
    }


}
