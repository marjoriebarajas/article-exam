<?php

namespace App\Modules;

abstract class AbstractRepository
{
    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function select($columns = ['*'])
    {
       return $this->model->select($columns);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        return $this->model->where($column, $operator, $value, $boolean);
    }

    public function lists($name = 'name', $id = '', $orderBy = array('name', 'asc'))
    {
        if($id != '') return $this->model->orderBy($orderBy[0], $orderBy[1])->lists($name, $id)->all();
        else return $this->model->orderBy($orderBy[0], $orderBy[1])->lists($name)->all();
    }

    public function pluck($name = 'name', $id = '')
    {
        if($id != '') return $this->model->pluck($name, $id);
        else return $this->model->pluck($name);
    }

    public function with($eagers = '')
    {
        return $this->model->with($eagers);
    }

    public function getAjaxResponse($type, $message)
    {
        return  response(
            array('message'=>$message,'type'=>$type)
        )->header('Content-Type', 'application/json');
    }
}