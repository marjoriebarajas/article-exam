<?php

namespace App\Modules\Admin\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            'name'              => 'required',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|min:6',
            'confirm_password'  => 'required|same:password',
            'company_name'      => 'required',
            'contact_number'    => 'required',
        ];
    }

    public function messages()
    {
        return [
            'password.min'              => 'Your password must be a minimum of 6 characters.',
            'confirm_password.required' => 'The re-type password field is required.',
            'confirm_password.same'     => 'The re-type password and password must match.',
        ];
    }
}