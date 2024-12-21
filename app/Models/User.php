<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Add this import
use Illuminate\Notifications\Notifiable; // Add this import
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable // Change from Model to Authenticatable
{
    use HasFactory, Notifiable; // Use Notifiable trait for notifications

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

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Add any additional methods related to authentication if necessary
}
