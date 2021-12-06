<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
// use App\Traits\DeleteFile;

class Operator extends Model
{
//   use DeleteFile;

  protected $fillable = [
      'name',
      'country_id',
      'rbt_sms_code',
      'image',
      'rbt_ussd_code',
  ];

  public function getImageAttribute($value)
  {
    return $value ? url($value) : '';
  }

  public function country()
  {
      return $this->belongsTo('App\Models\Country') ;
  }

  public function posts()
  {
    return $this->hasMany('App\Models\Post','operator_id','id');
  }

  public function rbts()
  {
    return $this->hasMany('App\Models\RbtCode','operator_id','id');
  }

  public function contents()
  {
    return $this->belongsToMany('App\Models\Content','posts','operator_id','content_id')->using(Post::class)
    ->withPivot('id','published_date','active','url','user_id')->withTimestamps();
  }

}
