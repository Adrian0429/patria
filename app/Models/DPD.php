<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DPD extends Model
{
    use HasFactory;

    protected $table = 'dpd';

    protected $fillable = [
        'nama_dpd', 'kode_daerah'
    ];

    public function dpc()
    {
        return $this->hasMany(DPC::class, 'dpd_id', 'id');
    }
}
