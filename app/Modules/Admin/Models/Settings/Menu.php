<?php

namespace App\Modules\Admin\Models\Settings;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $guarded = [];

    public function permissions()
    {
        // return $this->belongsToMany('App\Modules\Clinic\Models\Settings\Permissions', 'permissions', 'menu_id', 'role_id')->withTimestamps();
    }
}