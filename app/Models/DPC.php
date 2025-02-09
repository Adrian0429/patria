<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DPC extends Model
{
    use HasFactory;

    protected $table = 'DPC';

    protected $fillable = [
        'dpd_id','nama_dpc', 'kode_daerah'
    ];

    public function dpd()
    {
        return $this->belongsTo(DPD::class, 'dpd_id', 'id');
    }
}
