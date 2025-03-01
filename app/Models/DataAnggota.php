<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAnggota extends Model
{
    use HasFactory;

    protected $table = 'data_anggota';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'ID_Kartu', 'NIK', 'Nama_Lengkap', 'Nama_Buddhis', 'Jenis_Kelamin', 
        'Kota_Lahir', 'Tanggal_Lahir', 'Golongan_Darah', 'Gelar_Akademis', 
        'Profesi', 'Email', 'No_HP', 'Alamat', 'img_link', 'Status_Kartu', 
        'Mengenal_Patria_Dari', 'Histori_Patria', 'Pernah_Mengikuti_PBT', 'dpd_id', 'dpc_id'
    ];

    public function informasiAkses()
    {
        return $this->hasMany(InformasiAkses::class, 'id_anggota', 'id_anggota');
    }
}
