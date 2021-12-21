<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripGalley extends Model
{
    use HasFactory;

    protected $table = 'trip_galleys';
    protected $fillable = ['image', 'trip_id'];

    public function Trip()
    {
      return $this->belongsTo(Trip::class);
    }
}
