<?php

namespace App\Modules\Admin\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'email'             => 'required|email|unique:users,email,'.(($this->getId()) ? $this->getId():'NULL').',id',
            'confirm_password'  => 'required_with:password|nullable|min:6|same:password',
        ];
    }

    public function getId()
    {
        return decode(auth('admin')->user()->hashid);
    }
}