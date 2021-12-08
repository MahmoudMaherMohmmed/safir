<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Country extends Model
{
    use Translatable;
    
    protected $fillable = ['title'];

    public function trips()
    {
      return $this->hasMany(Trip::class);
    }
}
