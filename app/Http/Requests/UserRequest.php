<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use PhpParser\Node\Expr\FuncCall;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userID = $this->route('user');

        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . ($userID ? $userID->id : null),
            // 'password' => 'required|confirmed|min:6', //mínimo 6 caracteres
        ];
    }

    //Traduzir as mensagens de validação do formulário
    public function messages(){
        return[
            'name.required' => 'Campo nome Obrigatório!',
            'email.required' => 'Campo E-mail Obrigatório!',
            'email.email' => 'Necessário enviar um e-mail válido! example@site.com',
            'email.unique' => 'E-mail já cadastrado!',
            'password.required' => 'Campo senha Obrigatório!',
            'password.confirmed' => 'As senhas não são idênticas!',
            'password.min' => 'A senha deve ter no mínimo :min carateres!',
        ];

    }
}
