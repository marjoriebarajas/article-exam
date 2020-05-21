<?php
namespace App\Modules\Admin\Controllers\User;

use Auth;
use Datatables;
use Carbon\Carbon;
use App\Modules\BaseController;
use App\Modules\Admin\Requests\User\UserRequest;
use App\Modules\Admin\Requests\User\ProfileRequest;

use App\Modules\Admin\Repositories\User\User\UserRepositoryInterface as User;
use App\Modules\Admin\Repositories\User\Permission\PermissionRepositoryInterface as Permission;

class UserController extends BaseController{

	protected $auth;
    protected $user;
    protected $permission;
    public function __construct(User $user, Permission $permission)
    {
        $this->user = $user;
        $this->permission = $permission;
    	$this->auth = Auth::guard('admin');
        $this->activeMenu('users');
    }

    public function index()
    {
        $data['permission'] = $permission = $this->permissions();
        $this->authorize('access', $permission);
        return $this->view('Admin::user', 'index', $data);
    }

    public function store(UserRequest $request)
    {
        $permission = $this->permissions();
        $this->authorize('create', $permission);

        return $user = $this->user->create($request->all());
    }

    public function show($hashid)
    {
        $id = decode($hashid);
        $data['user'] = $this->user->select(['id','name', 'email', 'role_id'])->with(['role'])->find($id);
        return $this->view('Admin::user', 'profile', $data);
    }

    public function edit($hashid)
    {
        $permission = $this->permissions();
        $this->authorize('update', $permission);

        $id = decode($hashid);
        return $user = $this->user->with(['role'])->find($id);
    }

    public function update(UserRequest $request, $hashid)
    {
        $permission = $this->permissions();
        $this->authorize('update', $permission);

        $id = decode($hashid);
        return $user = $this->user->update($id, $request);
    }

    public function destroy($hashid)
    {
        $permission = $this->permissions();
        $this->authorize('delete', $permission);

        $id = decode($hashid);
        return $user = $this->user->delete($id);
    }

    public function updateProfile(ProfileRequest $request, $hashid)
    {
        $id = decode($hashid);
        $user = $this->user->updateProfile($id, $request);
        return redirect()->route('dashboard.index');
    }

    public function getUserData()
    {
        $users = $this->user->select('*')
                            ->where('client_id', clientId())
                            ->with(['role']);

        $permission = $this->permissions();
        return Datatables::of($users)
                ->addIndexColumn()
                ->editColumn('created_at', function($row){
                    return Carbon::parse($row->created_at)->format('F d, Y');
                })
                ->addColumn('action', function($row) use($permission){
                    $html = '';
                    if($row->type_id == 1){
                        return '<span class="label label-warning">Default</span>';
                    }else{
                        if($this->auth->user()->can('update', $permission)) {
                            $html .= '<span data-toggle="tooltip" data-placement="top" title="Edit"><button type="button"class="btn btn-xs btn-primary" data-toggle="modal" data-target="#users-modal" data-method="PUT" data-action="'.route('users.update', $row->hashid).'" data-details="'.route('users.edit', $row->hashid).'" data-backdrop="static"><i class="fa fa-pencil"></i></button></span>';
                        }
                        if($this->auth->user()->can('delete', $permission)) {
                            $html .= '&nbsp;&nbsp;<a href="#delete" class="btn btn-xs btn-danger" id="btn-user-delete" data-toggle="tooltip" data-placement="top" title="Delete" data-action="'.route('users.destroy', $row->hashid).'"><i class="fa fa-trash"></i></a>';
                        }
                    }
                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function permissions()
    {
        $menu_id = $this->user->getMenuId();
        return $this->permission->getPermission($menu_id);
    }
}