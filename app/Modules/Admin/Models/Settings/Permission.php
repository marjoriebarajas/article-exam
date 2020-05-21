<?php

namespace App\Modules\Admin\Models\Settings;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $fillable = [
        'client_id',
        'role_id',
        'menu_id',
        'can_access',
        'can_create',
        'can_update',
        'can_delete'
    ]; 
    protected $appends = ['hashid'];

    public function getHashidAttribute()
    {
        return hashid($this->id);
    }

    public function menu()
    {
        return $this->hasOne('App\Modules\Admin\Models\User\Role', 'id', 'menu_id');
    }
}