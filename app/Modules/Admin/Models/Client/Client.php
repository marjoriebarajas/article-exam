<?php

namespace App\Modules\Admin\Models\Client;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
    protected $guarded = [];
    protected $appends = ['hashid'];

    public function getHashidAttribute()
    {
        return hashid($this->id);
    }

    public function user()
    {
        return $this->hasMany('App\Modules\Admin\Models\User\User', 'client_id');
    }
}