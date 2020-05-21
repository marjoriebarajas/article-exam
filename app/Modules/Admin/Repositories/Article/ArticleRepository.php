<?php

namespace App\Modules\Admin\Repositories\Article;

use Auth;
use File;
use Storage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Modules\AbstractRepository;
use App\Modules\Admin\Models\Article\Article;

class ArticleRepository extends AbstractRepository implements ArticleRepositoryInterface
{
    protected $model;

    function __construct(Article $model)
    {
        $this->model = $model;
        $this->auth = Auth::guard('admin');
    }

    public function create(Request $request)
    {
        $client_id = $this->auth->user()->client->id;
        $file = $request->file('thumbnail');

        $model = $this->model->fill($request->all());
        if(!empty($file)){
            $model->thumbnail = $this->uploadThumbnail($file);
        }
        $model->client_id = $client_id;
        $model->slug = str_slug($request->title);
        $model->save();

        session()->flash('success_alert', 'Successfully added.');
        return $model;
    }

    public function update($id, Request $request)
    {
        $file = $request->file('thumbnail');
        $model = $this->model->find($id);
        if(!empty($file)){
            if(!empty($model->thumbnail)){
                $this->deleteThumbnail($model->thumbnail);
            }
            $image_path = $this->uploadThumbnail($file);
        }
        $model->fill($request->all());
        if(isset($image_path)){
            $model->thumbnail = $image_path;
        }else{
            if($request->old_image == 'none'){
                $this->deleteThumbnail($model->thumbnail);
                $model->thumbnail = '';
            }
        }
        $model->slug = str_slug($request->title);
        if(_count($model->getDirty()) > 0){
            $model->timestamps = true;
            $model->save();
            session()->flash('success_alert', 'Successfully updated.');
        }
        return $model;
    }

    public function delete($id)
    {
        $model = $this->model->find($id);
        $this->deleteThumbnail($model->thumbnail);
        $model->delete();
        return $this->getAjaxResponse('success', 'Successfully deleted.');
    }

    public function uploadThumbnail($file, $visibility = 'public')
    {
        $filename = set_upload_filename($file);
        $fullPath = 'articles/'.$filename;

        $photo =  File::get($file);
        Storage::put($fullPath, $photo, $visibility);
        return $filename;
    }

    public function deleteThumbnail($filename)
    {
        $image_fullpath = 'articles/'.$filename;
        if(Storage::exists($image_fullpath)){
            Storage::delete($image_fullpath);
        }
    }

    public function status()
    {
        return $this->model->status();
    }

    public function getLatestArticles($limit = 5)
    {
        return $this->getActiveArticle()->latest()->paginate($limit);
    }

    public function findBySlug($slug, $with=[])
    {
        if (!empty($with)){
            return $this->model->with($with)->where('slug', '=', $slug)->first();
        }
        return $this->model->where('slug', '=', $slug)->first();
    }

    protected function getActiveArticle()
    {
        $date_today = Carbon::now();
        return $this->model
                ->where('published_date', '<=', $date_today)
                ->where('status', 'Publish')
                ->where(function($query) use ($date_today){
                    $query->orWhere('expired_date', '>', $date_today);
                    $query->orWhere('expired_date', '=', '0000-00-00');
                });
     }

    public function getMenuId()
    {
        return $this->model->menu_id;
    }
}