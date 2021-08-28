<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingsRequest extends FormRequest
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
            //id is required and must be exist in table settings
            'id' => 'required|exists:settings',
            'value' => 'required',
            'plain_value' => 'nullable|numeric'
        ];
    }

    public function messages(){
        return [
            'id.required' => 'هذا البيان غير موجود',
            'id.exists:settings' => 'لم يتم الاضافة مسبقا فى الاعدادت',
            'value.required' => 'يجب ادخال طريقة الشحن',
        ];
    }
}
