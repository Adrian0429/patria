<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'user_id', 'attendance_date'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
