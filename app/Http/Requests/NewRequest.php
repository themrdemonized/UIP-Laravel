<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewRequest extends FormRequest
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
            'text' => 'required',
            'attachment' => 'nullable|max:10240|mimes:pdf,png,jpeg,gif,txt,jpg'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Данное поле является обязательным',
            'text.required' => 'Данное поле является обязательным',
            'attachment.max' => 'Максимальный размер файла - :max Кб',
            'attachment.mimes' => 'Расширение загружаемого вами файла не поддерживается',
        ];
    }
}
