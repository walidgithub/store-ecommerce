<?php

namespace App\Http\Requests;

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
            'name' => 'required',
            //email must unique in table admins exept this id (that mean you can update the name not email for this id)
            'email' => 'required|email|unique:admins,email,'.$this->id,
            'password' => 'nullable|confirmed|min:8'
        ];
    }

    public function messages(){
        return [
            'name.required' => 'يجب ادخال الاسم',
            'email.email' => 'ادخل صيغة الايميل بطريقة صحيحة',
            'email.required' => 'يجب ادخال الايميل',
            'email.unique' => ' الايميل مكرر',
            'password.confirmed' => 'لابد من تأكيد كلمة المرور',
            'password.min' => 'الباسورد 8 ارقام علي الاقل',
        ];
    }
}
