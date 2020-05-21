<?php

namespace App\Modules\Admin\Repositories\Client;

use DB;
use Auth;
use Illuminate\Http\Request;
use App\Modules\AbstractRepository;
use App\Modules\Admin\Models\Client\Client;

class ClientRepository extends AbstractRepository implements ClientRepositoryInterface
{
    protected $model;

    function __construct(Client $model)
    {
        $this->model = $model;
        $this->auth = Auth::guard('admin');
    }

    public function create(Request $request)
    {
        $model = $this->model->fill($request->only(['company_name', 'contact_number']));
        $model->save();

        return $model;
    }

    public function update($id, Request $request)
    {
        $model = $this->findById($id);
        $model->fill($request);

        if(_count($model->getDirty()) > 0) {
            $model->timestamps = true;
            $model->save();
            session()->flash('success_message', 'Clinic information successfully updated.');
        }
        return $model;
    }

    
    public function delete($id)
    {

    }
}