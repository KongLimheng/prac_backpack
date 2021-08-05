<?php

namespace App\Http\Requests\users;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateCrudRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->get('id') ?? request()->route('id');

        $rules           = [
            'Salutation'=> 'required|string|max:255',
            'FirstName'=> 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'password' => 'sometimes|nullable|min:4|max:20|confirmed',
            'phone'    => 'required|min:8|max:20|unique:users,phone',
            'email'     => 'sometimes|nullable|email:filter|max:255|unique:users,email',
        ];

        $rules['email']  = $rules['email'].",".$this->route('id') ??  '';
        $rules['phone']  = $rules['phone'].",".$this->route('id') ??  '';
        return $rules;
    }
}
