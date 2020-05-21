<?php

function _count($var)
{
    if(isset($var)) {
        if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
            return @count($var);
        } else {
            return count($var);
        }
    }
    return 0;
}

function get_template($file_path = "")
{
    $path = config('template.path');
    $name = config('template.name');
    return url($path.'/'.$name.'/'.$file_path);
}

function hashid($id = 0)
{
    $id =  \Hashids::encode($id);
    return $id;
}

function decode($hashid = "")
{
    if($hashid <> "")
    {
        $ids = \Hashids::decode($hashid);
        if(isset($ids[0])) return $ids[0];
    }
    return;   
}

function lists($datas = array())
{
    $rows = array();
    if(!empty($datas)) {
        foreach ($datas as $data_key => $data) {
           $rows[$data] = $data;
        }
    }
    return $rows;
}

function public_storage($path = '')
{
    return public_path('storage/'.$path);
}

function clientId()
{
    if(Auth::guard('admin')->check()){
        return Auth::guard('admin')->user()->client_id;
    }
    return 0;
}

function activeMenu($name)
{
    if($name == session('menu_name')){
        return 'active';
    }
}

function set_upload_filename($file, $fileExt = null)
{
    $random = substr(md5(mt_rand()), 0, 15);
    $datetime = Carbon\Carbon::now()->format('Ymdhis');
    if($fileExt != null){
        $extension = $fileExt;
    }else{
        $extension = $file->getClientOriginalExtension();
    }
    return $random.$datetime.'.'.$extension;
}

function get_article_thumbnail_path($filename)
{
    $article_folder = 'uploads/articles/';
    return $url = \Storage::disk('public')->url($article_folder.basename($filename));
}