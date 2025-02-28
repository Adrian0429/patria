<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PindahDaerah extends Model
{
    use HasFactory;

    protected $table = 'pindah_daerah';

    protected $fillable = [
        'id_anggota', 'asal_dpc', 'ke_dpc', 'user_id'
    ];

    public function asalDPC()
    {
        return $this->belongsTo(DPC::class, 'asal_dpc', 'id');
    }

    public function keDPC()
    {
        return $this->belongsTo(DPC::class, 'ke_dpc', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function dataAnggota()
    {
        return $this->belongsTo(DataAnggota::class, 'id_anggota', 'id');
    }
}
