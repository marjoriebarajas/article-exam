<?php

namespace App\Http\Controllers\Auth;

use Auth;
use JsValidator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Modules\Admin\Models\User\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';
    protected $guard = 'admin';
    protected $redirectAfterLogout = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('guest.admin')->except('logout');
    }

    public function getLogin()
    {
        $rules = array(
            'email' => 'required|email',
            'password' => 'required',
        );
        $data['page_type'] = 'Log-in';
        $data['validator'] = JsValidator::make($rules, array(), array(), '#login-form');
        return view('Admin::auth.login', $data);
    }

    public function postLogin(Request $request)
    {
        return $this->login($request);
    }

    protected function authenticated(Request $request, $user)
    {                
        $user = Auth::guard('admin')->user();
        return redirect($this->redirectTo);
    }

    public function guard() 
    {
        return Auth::guard('admin');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->regenerate();
        session()->flash('success_message', 'You have successfully logged out!');
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }
}
