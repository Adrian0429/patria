<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['event_name', 'event_logo', 'start_date', 'end_date'];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
