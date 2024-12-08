<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id'; // Specify the primary key
    public $incrementing = false; // Disable auto-incrementing since it's not an integer
    protected $keyType = 'string'; // Set the primary key type to string

    protected $fillable = [
        'user_id',
        'card_id',
        'email',
        'password',
        'nama_lengkap',
        'jenis_kelamin',
        'tanggal_lahir',
        'golongan_darah',
        'vihara',
        'image_link',
        'role',
    ];
}
