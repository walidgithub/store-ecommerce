<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
            //update slug in table tags exept this id (that mean you can update the name not slug for this id)
            'slug' => 'required|unique:tags,slug,'.$this->id,
        ];
    }

    public function messages(){
        return [
            'name.required' => 'يجب ادخال الاسم',
            'slug.required' => 'يجب الاسم بالرابط',
            'slug.unique' => ' الاسم بالرابط مكرر',
        ];
    }
}
