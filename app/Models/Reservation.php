<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    protected $fillable = ['client_id','trip_id', 'payment_method', 'status'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function bankTransfer()
    {
        return $this->hasOne(BankTransfer::class);
    }
}
