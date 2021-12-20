<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Trip extends Model
{
    use HasFactory;
    use Translatable;

    protected $table = 'trips';
    protected $fillable = ['title', 'description', 'price', 'persons_count', 'image', 'from', 'to', 'category_id', 'country_id', 'status'];

    public function category()
    {
      return $this->belongsTo(Category::class);
    }

    public function country()
    {
      return $this->belongsTo(Country::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
