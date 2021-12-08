<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Trip extends Model
{
    use HasFactory;
    use Translatable;

    protected $fillable = ['title', 'description', 'price', 'persons_count', 'image', 'category_id', 'country_id', 'status'];

    public function country()
    {
      return $this->belongsTo(Country::class);
    }
}
