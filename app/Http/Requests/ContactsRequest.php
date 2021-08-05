<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Contacts;
use Illuminate\Foundation\Http\FormRequest;

class ContactsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        // return backpack_auth()->check();
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $countIsVip = Contacts::where('is_vip', 1)->count();
        return [
            'owner' => 'required',
            // 'salutation' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'address_account' => 'required_if:type,==,"Personal"|nullable|string',
            'account_id' => 'required_if:type,==,"Business"|nullable|string',

            // 'is_vip' => 'required|nullable|lte:3'
            'is_vip' => [
                'nullable', 'boolean',
                function ($attribute, $value, $fail) use ($countIsVip) {
                    if ($countIsVip >= 100) {
                        $fail('The VIP cannot create more than 100 contact');
                    }
                }
            ],
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    // public function messages()
    // {
    //     return [
    //         'salutation.reuired' => 'A nice title is required for the post.',
    //         ['working_field.required'=> trans('user.your first name is required')],
    //     ];
    // }
    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator){
    //         if($this->is_vip){
    //             if(!$this->working_field){
    //                 $validator->errors()->add('occupation', 'The occupation is required when Is VIP Contact.');
    //             }
    //             if(!$this->occupation){
    //                 $validator->errors()->add('occupation', 'The occupation is required when Is VIP Contact.');
    //             }
    //             if(!$this->relationships){
    //                 $validator->errors()->add('relationships', 'The occupation is required when Is VIP Contact.');
    //             }
    //         }
    //     });
    // }
}
