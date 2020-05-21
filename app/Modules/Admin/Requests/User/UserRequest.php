<?php

namespace App\Modules\Admin\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->getId()) {
            return [
                'name'          => 'required',
                'email'         => 'required|email|unique:users,email,'.(($this->getId()) ? $this->getId():'NULL').',id',
                'role_id'       => 'required',
            ];
        }
        return [
            'name'              => 'required',
            'email'             => 'required|email|unique:users,email',
            'role_id'           => 'required',
            'password'          => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'role_id.required'   => 'The role field is required.',
        ];
    }

    public function getId()
    {
        return decode($this->user);
    }
}