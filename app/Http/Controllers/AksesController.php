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

         $aksess = InformasiAkses::LeftJoin('users', 'users.id', '=', 'informasi_akses.id_anggota')
            ->LeftJoin('data_anggota', 'data_anggota.id', '=', 'informasi_akses.id_anggota')
            ->paginate(10);

        return view('akses.home', compact('aksess'));
    }

}
