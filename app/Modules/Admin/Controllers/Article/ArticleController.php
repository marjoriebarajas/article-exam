<?php
namespace App\Modules\Admin\Controllers\Article;

use Auth;
use Datatables;
use Carbon\Carbon;
use App\Modules\BaseController;
use App\Modules\Admin\Requests\Article\ArticleRequest;

use App\Modules\Admin\Repositories\Article\ArticleRepositoryInterface as Article;
use App\Modules\Admin\Repositories\User\Permission\PermissionRepositoryInterface as Permission;

class ArticleController extends BaseController{

	protected $auth;
    protected $article;
    protected $permission;
    public function __construct(Article $article, Permission $permission)
    {
        $this->article = $article;
        $this->permission = $permission;
    	$this->auth = Auth::guard('admin');
        $this->activeMenu('articles');
    }

    public function index()
    {
        $data['permission'] = $permission = $this->permissions();
        $this->authorize('access', $permission);
        return $this->view('Admin::article', 'index', $data);
    }

    public function create()
    {
        $permission = $this->permissions();
        $this->authorize('create', $permission);
        $data = $this->getOptions();

        return $this->view('Admin::article', 'create', $data);
    }

    public function store(ArticleRequest $request)
    {
        $permission = $this->permissions();
        $this->authorize('create', $permission);

        $article = $this->article->create($request);
        return redirect()->route('articles.index');
    }

    public function show($hashid)
    {
        $id = decode($hashid);
        $data['page_type'] = 'Article Preview';
        $data['article'] = $this->article->findById($id);
        return $this->view('Admin::article', 'view', $data);
    }

    public function edit($hashid)
    {
        $permission = $this->permissions();
        $this->authorize('update', $permission);
        $data = $this->getOptions();

        $id = decode($hashid);
        $data['article'] = $this->article->findById($id);
        return $this->view('Admin::article', 'edit', $data);
    }

    public function update(ArticleRequest $request, $hashid)
    {
        $permission = $this->permissions();
        $this->authorize('update', $permission);

        $id = decode($hashid);
        $article = $this->article->update($id, $request);
        return redirect()->route('articles.index');
    }

    public function destroy($hashid)
    {
        $permission = $this->permissions();
        $this->authorize('delete', $permission);

        $id = decode($hashid);
        return $article = $this->article->delete($id);
    }

    public function getArticleData()
    {
        $articles = $this->article->select('*')
                            ->where('client_id', clientId());

        $permission = $this->permissions();
        return Datatables::of($articles)
                ->addIndexColumn()
                ->editColumn('published_date', function($row){
                    return Carbon::parse($row->published_date)->format('F d, Y');
                })
                ->editColumn('expired_date', function($row){
                    if($row->expired_date != '0000-00-00'){
                        return Carbon::parse($row->expired_date)->format('F d, Y');
                    }
                })
                ->addColumn('action', function($row) use($permission){
                    $html = '';
                    if($this->auth->user()->can('access', $permission)) {
                        $html .= '<a href="'.route('articles.show', $row->hashid).'" target="_blank" data-toggle="tooltip" title="Preview" class="btn btn-primary btn-xs btn-flat"><span class="fa fa-eye"></span></a>';
                    }
                    if($this->auth->user()->can('update', $permission)) {
                        $html .= '&nbsp;&nbsp;<a href="'.route('articles.edit', $row->hashid).'"><button type="button" data-toggle="tooltip" title="Update" class="btn btn-warning btn-xs btn-flat"><span class="fa fa-pencil"></span></button></a>';
                    }
                    if($this->auth->user()->can('delete', $permission)) {
                        $html .= '&nbsp;&nbsp;<a href="#delete" class="btn btn-xs btn-danger" id="btn-article-delete" data-action="'.route('articles.destroy', $row->hashid).'" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o"></i></a>';
                    }
                    return $html;
                })
                ->rawColumns(['action', 'status_display'])
                ->make(true);
    }

    public function getOptions()
    {
        $data['status'] =  [
                                'Publish' => 'Publish',
                                'Draft' => 'Draft',
                                'Inactive' => 'Inactive'
                            ];
        return $data;
    }

    public function permissions()
    {
        $menu_id = $this->article->getMenuId();
        return $this->permission->getPermission($menu_id);
    }
}