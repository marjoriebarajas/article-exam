<?php

namespace App\Modules;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

use App\Modules\Admin\Models\Settings\Menu;
use App\Modules\Admin\Models\Settings\Permission;

class AdminServiceProvider extends ServiceProvider
{

    protected $namespace = 'App\Modules';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $modules = config('modules.modules');
        array_filter($modules, function($module) use ($router){
            if(strtolower($module) != 'api')
            {
                $this->registerModuleRoute($router, $module);
                $this->registerModuleView($module);
            }
        });

        view()->composer(['Admin::layouts'], function($view) {
            if (auth('admin')->check()) 
            {
                $model_menu = new Menu;
                $menus = $model_menu->all();
                $permissions = [];
                $menu_ids = [];
                foreach ($menus as $key => $menu) {
                    $menu_ids[] = $menu->id;
                    $permissions['permissions'.$menu->id] = null;
                }
                $menu_permissions = $this->getPermissions($menu_ids);
                foreach ($menu_permissions as $key => $m_permission) {
                    $permission_key = 'permissions'.$m_permission->menu_id;
                    if(array_key_exists($permission_key, $permissions)){
                        $permissions[$permission_key] = $m_permission;
                    }
                }
                $view->with($permissions);
            }  
        });
    }

    public function getPermissions($menu_ids)
    {
        $permission = new Permission;
        $user = auth('admin')->user();
        return $permission->where('client_id', '=', $user->client_id)
                            ->where('role_id', '=', $user->role_id)
                            ->whereIn('menu_id', $menu_ids)
                            ->with('menu')
                            ->orderBy('menu_id', 'asc')
                            ->get();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->setAdminInterface();
    }

    public function registerModuleView($module)
    {
        return $this->loadViewsFrom(__DIR__."/$module/Views", $module);
    }

    public function registerModuleRoute($router, $module)
    {
        $router->group([
            'namespace' => $this->namespace.'\\'.$module.'\\'.'Controllers',
            'middleware' => 'web',
            'prefix' => strtolower($module)
        ], function ($router) use ($module) {
                require __DIR__."/$module/routes.php";
        });
    }   

    public function setAdminInterface()
    {
        $this->app->bind(
            \App\Modules\Admin\Repositories\Client\ClientRepositoryInterface::class,
            \App\Modules\Admin\Repositories\Client\ClientRepository::class
        );
        $this->app->bind(
            \App\Modules\Admin\Repositories\User\Role\RoleRepositoryInterface::class,
            \App\Modules\Admin\Repositories\User\Role\RoleRepository::class
        );
        $this->app->bind(
            \App\Modules\Admin\Repositories\User\User\UserRepositoryInterface::class,
            \App\Modules\Admin\Repositories\User\User\UserRepository::class
        );
        $this->app->bind(
            \App\Modules\Admin\Repositories\User\Permission\PermissionRepositoryInterface::class,
            \App\Modules\Admin\Repositories\User\Permission\PermissionRepository::class
        );
        $this->app->bind(
            \App\Modules\Admin\Repositories\Article\ArticleRepositoryInterface::class,
            \App\Modules\Admin\Repositories\Article\ArticleRepository::class
        );
    } 
}
