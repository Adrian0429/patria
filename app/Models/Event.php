<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo', 'start_date', 'end_date', 'created_by'];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}