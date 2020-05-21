<?php

namespace App\Modules\Admin\Models\User;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $guarded = [];
    protected $appends = ['hashid'];
    public $menu_id = 3;

    public function getHashidAttribute()
    {
        return hashid($this->id);
    }

    public function client()
    {
        return $this->belongsTo('App\Modules\Admin\Models\Client\Client', 'client_id');
    }

    public function role()
    {
        return $this->belongsTo('App\Modules\Admin\Models\User\Role', 'role_id');
    }
}