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
    $aksess = InformasiAkses::query()
        ->select('informasi_akses.*', 'users.nama as user_nama', 'users.email as user_email')
        ->join('users', 'informasi_akses.user_id', '=', 'users.id')
        ->orderBy('informasi_akses.created_at', 'desc')
        ->paginate(10);

    return view('akses.home', compact('aksess'));
}


}
