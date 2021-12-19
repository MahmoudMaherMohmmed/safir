<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Media extends Model
{
    use HasFactory;
    use Translatable;

    protected $table = 'media';
    protected $fillable = ['title', 'image', 'video', 'views', 'status'];

}
