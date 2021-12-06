<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Provider extends Model
{
    use Translatable;
    protected $table = 'providers';
    protected $fillable = ['title', 'image']; 

    ///////////////////set image///////////////////////////////
    public function setImageAttribute($value)
    {
        $img_name = time() . rand(0, 999) . '.' . $value->getClientOriginalExtension();
        $value->move(base_path('/uploads/provider'), $img_name);
        $this->attributes['image'] = $img_name;
    }

    public function getImageAttribute($value)
    {
        // dd($value);
        if ($value) {
            return url('/uploads/provider/' . $value);
        }
        return false;

    }
    public function categories()
    {
        return $this->hasMany('App\Models\Category', 'provider_id', 'id');
    }
}
