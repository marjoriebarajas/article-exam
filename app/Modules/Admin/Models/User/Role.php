<?php

namespace App\Modules\Admin\Models\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $guarded = [];
    protected $appends = ['hashid'];
    public $menu_id = 2;

    public function getHashidAttribute()
    {
        return hashid($this->id);
    }

    public function permissions()
    {
        return $this->hasMany('App\Modules\Admin\Models\Settings\Permission', 'role_id', 'id');
    }

    public function users()
    {
        return $this->hasMany('App\Modules\Admin\Models\User\User', 'role_id');
    }
}