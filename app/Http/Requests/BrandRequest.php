<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            //to make it optional to edit or not
            //you must send id in request in input hidden in edit page
            'photo' => 'required_without:id|mimes:jpg,jpeg,png',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'يجب ادخال الاسم',
            'photo.required' => ' الاسم بالرابط مكرر',
        ];
    }
}
