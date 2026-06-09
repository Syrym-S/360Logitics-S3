<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RemoteService extends Model
{
    protected $table = 'remote_services';

    protected $fillable = [
        'name',
    ];

    public function files()
    {
        return $this->hasMany(File::class, 'remote_service_id');
    }
}