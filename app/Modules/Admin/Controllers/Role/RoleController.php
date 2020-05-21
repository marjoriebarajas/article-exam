<?php
namespace App\Modules\Admin\Controllers\Role;

use Auth;
use Datatables;
use Carbon\Carbon;
use App\Modules\BaseController;
use Illuminate\Http\Request;
use App\Modules\Admin\Requests\Role\RoleRequest;

use App\Modules\Admin\Repositories\User\Role\RoleRepositoryInterface as Role;
use App\Modules\Admin\Repositories\User\Permission\PermissionRepositoryInterface as Permission;

class RoleController extends BaseController{

	protected $auth;
    protected $role;
    protected $permission;
    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    	$this->auth = Auth::guard('admin');
        $this->activeMenu('roles');
    }

    public function index()
    {
        $data['permission'] = $permission = $this->permissions();
        $this->authorize('access', $permission);
        return $this->view('Admin::role', 'index', $data);
    }

    public function store(RoleRequest $request)
    {
        $permission = $this->permissions();
        $this->authorize('create', $permission);

        return $role = $this->role->create($request);
    }

    public function edit($hashid)
    {
        $permission = $this->permissions();
        $this->authorize('update', $permission);

        $id = decode($hashid);
        return $role = $this->role->findById($id);
    }

    public function update(RoleRequest $request, $hashid)
    {
        $permission = $this->permissions();
        $this->authorize('update', $permission);

        $id = decode($hashid);
        return $role = $this->role->update($id, $request);
    }

    public function destroy($hashid)
    {
        $permission = $this->permissions();
        $this->authorize('delete', $permission);

        $id = decode($hashid);
        return $role = $this->role->delete($id);
    }

    public function getRoleData()
    {
        $roles = $this->role->select('*')
                            ->where('client_id', clientId());
        $permission = $this->permissions();
        return Datatables::of($roles)
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
                            $html .= '<span data-toggle="tooltip" data-placement="top" title="Edit"><button type="button"class="btn btn-xs btn-primary" data-toggle="modal" data-target="#roles-modal" data-method="PUT" data-action="'.route('roles.update', $row->hashid).'" data-details="'.route('roles.edit', $row->hashid).'" data-backdrop="static"><i class="fa fa-pencil"></i></button></span>';
                        }
                        if($this->auth->user()->can('delete', $permission)) {
                            $html .= '&nbsp;&nbsp;<a href="#delete" class="btn btn-xs btn-danger" id="btn-role-delete" data-toggle="tooltip" data-placement="top" title="Delete" data-action="'.route('roles.destroy', $row->hashid).'"><i class="fa fa-trash"></i></a>';
                        }
                    }
                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function roleSelect2(Request $request)
    {
        return $this->role->roleSelect2($request->all());
    }

    public function permissions()
    {
        $menu_id = $this->role->getMenuId();
        return $this->permission->getPermission($menu_id);
    }
}