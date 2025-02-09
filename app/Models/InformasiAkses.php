<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiAkses extends Model
{
    use HasFactory;

    protected $table = 'informasi_akses';

    protected $fillable = [
        'type', 'user_id', 'id_anggota', 'keterangan', 'nama_penginput', 'jabatan_penginput'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function dataAnggota()
    {
        return $this->belongsTo(DataAnggota::class, 'id_anggota', 'id');
    }
}
