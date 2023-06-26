<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObjecttRequest extends FormRequest
{
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
            'empty_flats' => 'nullable|integer',
            'empty_parking' => 'nullable|integer',
            'empty_pantry' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
          'name.required' => 'Укажите название',
          'empty_flats.integer' => 'Укажите числовое значение',
          'empty_parking.integer' => 'Укажите числовое значение',
          'empty_pantry.integer' => 'Укажите числовое значение',
        ];
    }
}
