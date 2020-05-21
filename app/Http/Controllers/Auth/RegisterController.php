<?php

namespace App\Http\Controllers\Auth;

use Auth;
use JsValidator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Modules\Admin\Requests\Auth\RegisterRequest;

use App\Modules\Admin\Repositories\Client\ClientRepositoryInterface as Client;
use App\Modules\Admin\Repositories\User\Role\RoleRepositoryInterface as Role;
use App\Modules\Admin\Repositories\User\User\UserRepositoryInterface as User;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';
    protected $client;
    protected $role;
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Client $client, Role $role, User $user)
    {
        $this->middleware('guest.admin');
        $this->client = $client;
        $this->role = $role;
        $this->user = $user;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function getRegister()
    {
        $data['page_type'] = 'Register';
        return view('Admin::auth.register', $data);
    }

    public function postRegister(RegisterRequest $request)
    {
        $client = $this->client->create($request);

        $role = $this->role->createDefaultRole($client->id); //add default permission
        $data['client_id'] = $client->id;
        $data['role_id'] = $role->id;
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = bcrypt($request->password);
        $data['type_id'] = 1;
        $user = $this->user->create($data);

        session()->flash('success_alert', 'Account created successfully. You may log in with the credentials you provided.');
        return redirect()->route('admin.get-login');
    }
}
