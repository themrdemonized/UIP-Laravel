<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfficeRequest extends FormRequest
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
            'area' => 'required',
            'coast' => 'required',
            'coordinates' => 'required',
            'dx' => 'required',
            'dy' => 'required',
            'status_id' => 'required',
            'floor_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Укажите номер офиса',
            'area.required' => 'Укажите площадь',
            'coast.required' => 'Укажите стоимость',
            'dx.required' => 'Укажите dx',
            'dy.required' => 'Укажите dy',
            'coordinates.required' => 'Укажите координаты офиса для svg холста',
            'status_id.required' => 'Укажите статус, в котором находится офис',
            'floor_id.required' => 'Укажите дом, в котором находится офис',
        ];
    }
}
