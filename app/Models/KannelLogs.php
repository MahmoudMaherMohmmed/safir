<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KannelLogs extends Model
{
    protected $table = 'kannel_logs';
    protected $fillable = ['kannel_id', 'connection_name', 'ip', 'port', 'status', 'sent', 'queued', 'failed', 'throughput'];

    public function kannel()
    {
        return $this->belongsTo(Kannel::class);
    }
}
