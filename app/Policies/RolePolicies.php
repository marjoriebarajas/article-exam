<?php

namespace App\Policies;

use App\Modules\Admin\Models\User\User;
use App\Modules\Admin\Models\Settings\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicies
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function access(User $user, Permission $permission)
    {
        return $permission->can_access;
    }

    public function create(User $user, Permission $permission)
    {
        return $permission->can_access == $permission->can_create;
    }

    public function update(User $user, Permission $permission)
    {
        return $permission->can_access == $permission->can_update;
    }

    public function delete(User $user, Permission $permission)
    {
        return $permission->can_access == $permission->can_delete;
    }

    public function superAdmin(User $user, Permission $permission)
    {
        return $user->type_id == 1;
    }
}
