<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhotoReportsRequest extends FormRequest
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
            'house_id' => 'required',
            'images' => 'nullable|max:10240'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Укажите название',
            'house_id.required' => 'Выберите дом',
        ];
    }
}
