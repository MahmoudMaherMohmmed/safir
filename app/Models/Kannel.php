<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kannel extends Model
{
    protected $table = 'kannels';
    protected $fillable = ['title', 'url', 'excel_link', 'status'];

    public function logs()
    {
        return $this->hasMany(KannelLogs::class);
    }
}
