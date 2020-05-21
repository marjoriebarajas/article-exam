<?php

namespace App\Modules\Admin\Repositories\User\User;

use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Modules\AbstractRepository;

use App\Modules\Admin\Models\User\User;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    protected $auth;
    protected $model;
    function __construct(User $model)
    {
        $this->auth = Auth::guard('admin');
        $this->model = $model;
    }

    public function create(array $request)
    {
        $model = $this->model->fill($request);
        if($this->auth->check()){
            $user = $this->model->where('email', $request['email'])->first();
            if($user){
                return $this->getAjaxResponse('error', 'Email already exists.');
            }
            $model->client_id = $this->auth->user()->client_id;
            $model->password = bcrypt($request['password']);
            $model->type_id = 0;
        }
        $model->save();
        return $this->getAjaxResponse('success', 'User successfully added.');
    }

    public function update($id, Request $request)
    {
        $user = $this->model->where('email', $request->email)->where('id', '!=', $id)->first();
        if($user){
            return $this->getAjaxResponse('error', 'Email already exists.');
        }
        $model = $this->findById($id);
        $model->fill($request->except('password'));

        if(_count($model->getDirty()) > 0){
            $model->save();
            return $this->getAjaxResponse('success', 'User successfully updated.');
        }
        return $model;
    }

    public function updateProfile($id, Request $request)
    {
        $model = $this->findById($id);
        $model->fill($request->except('password', 'confirm_password'));
        if($request->password){
            $model->password = bcrypt($request->password);
        }

        if(_count($model->getDirty()) > 0){
            $model->save();
            session()->flash('success_alert', 'Profile successfully updated.');
        }
        return $model;
    }

    public function delete($id)
    {
        $model = $this->findById($id);
        $model->delete();
        return response()->json(['type' => 'success', 'message' => 'User is successfully deleted.']);
    }

    public function getMenuId()
    {
        return $this->model->menu_id;
    }
}