<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:3|confirmed',
        ];
    }

    public function messages()
    {
       return [
           'email.required' => 'Данное поле является обязательным',
           'email.email' => 'Неверный формат',
           'email.unique' => 'Такой пользователь уже существует',
           'password.required' => 'Данное поле является обязательным',
           'password.min' => 'Минимальна длина пароля :min',
           'password.confirmed' => 'Введенные пароли не совпадают',
       ];
    }
}
