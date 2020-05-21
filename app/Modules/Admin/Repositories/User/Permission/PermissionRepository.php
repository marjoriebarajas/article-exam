<?php

namespace App\Modules\Admin\Repositories\User\Permission;

use Auth;
use Carbon\Carbon;
use App\Modules\AbstractRepository;

use App\Modules\Admin\Models\User\Role;
use App\Modules\Admin\Models\User\User;
use App\Modules\Admin\Models\Settings\Menu;
use App\Modules\Admin\Models\Settings\Permission;

class PermissionRepository extends AbstractRepository implements PermissionRepositoryInterface
{
    protected $model;

    function __construct(Permission $model)
    {
        $this->model = $model;
    }

    public function create(array $request)
    {
        $data =[];
        if(_count($request['menu_access']) > 0){
            foreach ($request['menu_access'] as $key => $value) {
                $model = new Permissions;
                $model->client_id = Auth::guard('admin')->user()->client_id;
                $model->role_id = $request['role_id'];
                $model->menu_id = $key;
                $model->can_read = (int)( (isset($value['can_read']) || isset($value['can_write'])) ? 1:0 );
                $model->can_write = (int)( isset($value['can_write']) ? 1:0 );
                $model->timestamps = true;
                $model->save();
            }
        }
        return true;

    }

    public function update(array $request, $role_id)
    {
        $datas = [];
        $client_id = Auth::guard('admin')->user()->client_id;
        // return $request;
        $menu_ids = array_keys($request);
        $role_exist = $this->model
                                ->WhereClinicId()
                                ->where('role_id', '=', $role_id)
                                ->whereNotIn('menu_id', $menu_ids)
                                ->delete();//delete

        if(_count($request) > 0){
            foreach ($request as $menu_id => $permission) {
                $perm = new Permissions;
                $hasPermission = $perm->select(['*'])
                                ->where('role_id', '=', $role_id)
                                ->where('menu_id', '=', $menu_id)
                                ->first();
                $permission_data = [
                        'client_id' => $client_id,
                        'role_id' => $role_id,
                        'menu_id' => $menu_id,
                        'can_read' => ( isset($permission['can_read']) || isset($permission['can_write']) ? 1:0),
                        'can_write' => ( isset($permission['can_write']) ? 1:0)
                ];
                if(_count($hasPermission) > 0){
                    $hasPermission->fill($permission_data);
                    $hasPermission->timestamps = true;
                    $hasPermission->save();
                    // $datas[] = $hasPermission;
                }else{
                    $model = new Permissions;
                    $model->fill($permission_data);
                    $model->timestamps = true;
                    $model->save();
                }
            }
        }

        return true;
    }

    public function getPermission($menu_id)
    {
        $user = Auth::guard('admin')->user();
        $permission = $this->model
                            ->where('client_id', '=', $user->client_id)
                            ->where('role_id', '=', $user->role_id)
                            ->where('menu_id', '=', $menu_id)
                            ->first();
        return $permission;
    }

    public function getPermissions($menu_ids)
    {
        $permission = new Permissions;
        $user = auth('clinic')->user();
        $menu_permissions = $permission->where('client_id', '=', $user->client_id)
                            ->where('role_id', '=', $user->role_id)
                            ->whereIn('menu_id', $menu_ids)
                            ->with('menu')
                            ->orderBy('menu_id', 'asc')
                            ->get();
        $permissions = [];
        $permissions_key = [];
        foreach ($menu_ids as $key => $value) {
            $words = preg_replace('/[0-9]+/', '', $key);
            $permissions_key[$words] = preg_replace('/[^0-9]+/', '', $key);
            $permissions[$words] = null;
        }
        foreach ($menu_permissions as $mkey => $m_permission) {
            $key = array_search($m_permission->menu_id, $permissions_key);
            if($key){
                $permissions[$key] = $m_permission;
            }
        }
        return $permissions;
    }
}