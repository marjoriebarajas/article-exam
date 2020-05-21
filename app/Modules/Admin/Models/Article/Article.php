<?php

namespace App\Modules\Admin\Models\Article;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;

class Article extends Model
{
    use FormAccessible;

    protected $table = 'articles';
    protected $guarded = ['old_image'];
    protected $appends = ['hashid', 'status_display'];
    public $menu_id = 4;

    public function getHashidAttribute()
    {
        return hashid($this->id);
    }

    public function getStatusDisplayAttribute()
    {
        if($this->status == 'Publish') return '<span class="label label-success">Publish</span>';
        else if($this->status == 'Draft') return '<span class="label label-warning">Draft</span>';
        else if($this->status == 'Inactive') return '<span class="label label-danger">Inactive</span>';
    }

    public function setPublishedDateAttribute($value)
    {
        if(!empty($value) && $value != '0NaN-NaN-NaN') {
            return $this->attributes['published_date'] = Carbon::parse($value)->format('Y-m-d');
        }
        return $this->attributes['published_date'] = '';
    }
    
    public function formPublishedDateAttribute($value)
    {
        if($value <> '0000-00-00') {
            return Carbon::parse($value)->format('m/d/Y');
        };
        return '';
    }

    public function setExpiredDateAttribute($value)
    {
        if(isset($value) && !empty($value) && $value != '0NaN-NaN-NaN') {
            return $this->attributes['expired_date'] = Carbon::parse($value)->format('Y-m-d');
        }
        return $this->attributes['expired_date'] = '0000-00-00';
    }
    
    public function formExpiredDateAttribute($value)
    {
        if($value <> '0000-00-00') {
            return Carbon::parse($value)->format('m/d/Y');
        };
        return '';
    }

    public function client()
    {
        return $this->hasMany('App\Modules\Admin\Models\Client\Client', 'client_id');
    }
}