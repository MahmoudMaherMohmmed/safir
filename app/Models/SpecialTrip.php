<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialTrip extends Model
{
    use HasFactory;

    protected $table = 'special_trips';
    protected $fillable = ['client_id', 'country_id', 'start_date', 'days_count', 'persons_count', 'description', 'status'];
}
