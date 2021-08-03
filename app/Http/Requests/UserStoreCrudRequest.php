<?php

namespace app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreCrudRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
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
            // 'name' => 'required|min:5|max:255'
            'Salutation' => 'required|string|max:255',
            'FirstName' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'phone'     => 'required|min:8|max:20|unique:users,phone',
            'email'     => 'sometimes|nullable|email:filter|max:255|unique:users,email',
            'password' => 'required|confirmed',
        ];
    }
}
