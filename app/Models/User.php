<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama', 'jabatan', 'email', 'password', 'dpd_id', 'dpc_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function dpd()
    {
        return $this->hasOne(DPD::class, 'dpd_id', 'id')->withDefault();
    }

    public function dpc()
    {
        return $this->hasOne(DPC::class, 'dpc_id', 'id')->withDefault();
    }

    public function dataAnggota()
    {
        return $this->hasMany(DataAnggota::class, 'created_by', 'user_id');
    }

    public function informasiAkses()
    {
        return $this->hasMany(InformasiAkses::class, 'user_id', 'user_id');
    }
}
