<?php 
namespace App\Modules;

use Auth;
use App\Http\Controllers\Controller;

abstract class BaseController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function view($view = '', $action = 'index',  $data = array(), $guard = 'admin')
    {
        $custom_dir = Auth::guard($guard)->user()->id;
        $custom_view = $view.'.'.$custom_dir.'.'.$action;

        if (view()->exists($custom_view))
        {
           return view($custom_view, $data);
        } 

        return view($view.'.'.$action, $data);
    }

    public function activeMenu($menu_name)
    {
        session()->flash('menu_name', $menu_name);
        session()->flash('menu_title', ucwords($menu_name));
    }

}
