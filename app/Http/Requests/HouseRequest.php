<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HouseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'floors' => 'required|integer',
            'description' => 'required',
            'img' => 'required',
            'viewBox' => 'required',
            'coordinates' => 'required',
            'status_id' => 'required|integer',
            'object_id' => 'required|integer',
            'empty_flats' =>'nullable|integer'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Укажите номер дома',
            'floors.required' => 'Укажите количество этажей в доме',
            'description.required' => 'Укажите описание для всплывающего окна',
            'img.required' => 'Укажите расположение изображения',
            'viewBox.required' => 'Укажите viewBox для svg холста',
            'coordinates.required' => 'Укажите координаты дома для svg холста',
            'status_id.required' => 'Укажите статус, в котором находится здание',
            'object_id.required' => 'Укажите объект, в котором находится здание',
            'empty_flats.integer' => 'Укажите значение в числовом формате',
            'floors.integer' => 'Укажите значение в числовом формате',
            'status_id.integer' => 'Укажите значение в числовом формате',
            'object_id.integer' => 'Укажите значение в числовом формате',
        ];
    }
}
