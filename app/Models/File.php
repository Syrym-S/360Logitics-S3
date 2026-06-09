<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files'; 

    protected $fillable = [
        'key',
        'remote_service_id',
        'path',
        'mime_type',
        'source',
        'creator',
        'auth',
        'is_deleted',
    ];

    public function remoteService()
    {
        return $this->belongsTo(RemoteService::class, 'remote_service_id');
    }
}