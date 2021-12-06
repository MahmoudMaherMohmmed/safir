<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';
    protected $fillable = ['doctor_id', 'date', 'from', 'to', 'status'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
