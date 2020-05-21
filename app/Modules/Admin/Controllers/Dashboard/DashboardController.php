<?php
namespace App\Modules\Admin\Controllers\Dashboard;

use Auth;
use App\Modules\BaseController;

class DashboardController extends BaseController{

	protected $auth;
    protected $menu_id = 0;
    public function __construct()
    {
    	$this->auth = Auth::guard('admin');
        $this->activeMenu('dashboard');
    }

    public function index()
    {
        return view('Admin::dashboard.index');
    }
}