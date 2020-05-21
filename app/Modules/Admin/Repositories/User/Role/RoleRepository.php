<?php

namespace App\Modules\Admin\Repositories\User\Role;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Modules\AbstractRepository;

use App\Modules\Admin\Models\User\Role;
use App\Modules\Admin\Models\User\User;
use App\Modules\Admin\Models\Settings\Menu;
use App\Modules\Admin\Models\Settings\Permission;

class RoleRepository extends AbstractRepository implements RoleRepositoryInterface
{
    protected $auth;
    protected $model;
    protected $menu;
    protected $user;
    protected $permission;
    function __construct(Role $model, Menu $menu, User $user, Permission $permission)
    {
        $this->auth = Auth::guard('admin');
        $this->model = $model;
        $this->menu = $menu;
        $this->user = $user;
        $this->permission = $permission;
    }

    public function create(Request $request)
    {
        $client_id = $this->auth->user()->client_id;
        $model = $this->model->fill($request->all());
        $model->client_id = $client_id;
        $model->type_id = 0;
        $model->save();
        $this->defaultRole($client_id, $model);
        return $this->getAjaxResponse('success', 'Role successfully added.');
    }

    public function update($id, Request $request)
    {
        $model = $this->findById($id);
        $model->fill($request->all());

        if(_count($model->getDirty()) > 0){
            $model->save();
            return $this->getAjaxResponse('success', 'Role successfully updated.');
        }
        return $model;
    }

    public function delete($id)
    {
        $role = $this->findById($id);
        $check_users =  $role->users()->count();
        if($check_users > 0){
            return $this->getAjaxResponse('error', 'Role is currently in used and cannot be deleted.');
        }
        $role->permissions()->delete();
        $role->delete();
        return $this->getAjaxResponse('success', 'Role successfully deleted.');
    }

    public function createDefaultRole($client_id)
    {
        $admin_role = $this->model->where('client_id', $client_id)->where('type_id', 1)->first();
        $user_role = $this->model->where('client_id', $client_id)->where('type_id', 2)->first();

        if(!$admin_role){
            $role = $this->model;
            $role->client_id = $client_id;
            $role->name = "Administrator";
            $role->description = "Administrator";
            $role->type_id = 1;
            $role->save();

            $menus = $this->menu->select('*')->get();
            foreach ($menus as $key => $menu) {
                $permission = new $this->permission;
                $permission->client_id = $client_id;
                $permission->role_id = $role->id;
                $permission->menu_id = $menu->id;
                $permission->can_access = 1;
                $permission->can_create = 1;
                $permission->can_update = 1;
                $permission->can_delete = 1;
                $permission->save();
            }
        }

        if(!$user_role){
            $this->createUserRole($client_id);
        }

        return $admin_role ? $admin_role : $role;
    }

    public function createUserRole($client_id)
    {
        $user_role = new $this->model;
        $user_role->client_id = $client_id;
        $user_role->name = "User";
        $user_role->description = "User";
        $user_role->type_id = 2;
        $user_role->save();

        $this->defaultRole($client_id, $user_role);
        
        return $user_role;
    }

    public function defaultRole($client_id, $role)
    {
        $timestamps = Carbon::now();
        $permission_data = [
            ['client_id' => $client_id, 'role_id' => $role->id, 'menu_id' => 1, 'can_access' => 0, 'can_create' => 0, 'can_update' => 0, 'can_delete' => 0, 'created_at' => $timestamps, 'updated_at' => $timestamps],
            ['client_id' => $client_id, 'role_id' => $role->id, 'menu_id' => 2, 'can_access' => 0, 'can_create' => 0, 'can_update' => 0, 'can_delete' => 0, 'created_at' => $timestamps, 'updated_at' => $timestamps],
            ['client_id' => $client_id, 'role_id' => $role->id, 'menu_id' => 3, 'can_access' => 0, 'can_create' => 0, 'can_update' => 0, 'can_delete' => 0, 'created_at' => $timestamps, 'updated_at' => $timestamps],
            ['client_id' => $client_id, 'role_id' => $role->id, 'menu_id' => 4, 'can_access' => 1, 'can_create' => 1, 'can_update' => 1, 'can_delete' => 1, 'created_at' => $timestamps, 'updated_at' => $timestamps]
        ];

        return $this->permission->insert($permission_data);
    }

    public function roleSelect2(array $request)
    {
        $name = '';
        if(isset($request['name'])){
            $name = preg_replace('/\s+/', '', $request['name']);
        }

        $data = $this->model
                        ->select([\DB::raw("name AS text"), 'id'])
                        ->where('client_id', clientId())
                        ->where('name', 'like', '%'.$name.'%')
                        ->orderBy('type_id', 'asc')
                        ->orderBy('name', 'asc')
                        ->get()->toArray();

        return $data;
    }

    public function getMenuId()
    {
        return $this->model->menu_id;
    }
}