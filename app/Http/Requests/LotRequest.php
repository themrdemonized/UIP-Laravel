<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LotRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => 'required',
            'flat_id' => 'required|integer',
            'price' => 'required',
            'attachment' => 'nullable|max:10240|mimes:pdf,png,jpeg,gif,txt,jpg'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Данное поле является обязательным',
            'flat_id.required' => 'Данное поле является обязательным',
            'flat_id.integer' => 'Данное поле является числовым',
            'price.required' => 'Данное поле является обязательным',
            'attachment.max' => 'Максимальный размер файла - :max Кб',
            'attachment.mimes' => 'Расширение загружаемого вами файла не поддерживается',
        ];
    }
}
