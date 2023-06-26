<?php

namespace App\Http\Requests;

use App\Rules\RecaptchRule;
use Illuminate\Foundation\Http\FormRequest;

class PartisipantRequest extends FormRequest
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

    public function rules(RecaptchRule $recaptchRule)
    {
        return [
            'email' => 'required|email',
            'number' => 'required',
            'name' => 'required',
            'recaptcha_token' => ['required', $recaptchRule]
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Укажите email',
            'number.required' => 'Укажите номер телефона',
            'name.required' => 'Укажите ФИО',
            'recaptcha_token.required' => 'Капча не пройдена',
        ];
    }
}
