<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSaveRequest extends FormRequest {

    public function authorize(): bool {

        return true;
    }

    /** @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> */

    public function rules() {
        
        $rules = [
            'name' => 'required|string|min:3|max:255',
            'cnpj_cpf' => 'nullable|digits_between:11,14|unique:users,cnpj_cpf,'.$this->user.',id',
            'email' => 'required|string|email|unique:users,email,'.$this->user.',id',
            'tel_cel' => 'nullable|digits:11',
            'password' => 'required|string|min:6|confirmed',
        ];

        if($this->method() === 'PATCH') {

            $dinamicRules = [];

            foreach($rules as $input => $rule) {

                if(array_key_exists($input, $this->request->all())) {

                    $dinamicRules[$input] = $rule;
                }
            }

            return $dinamicRules;
        }

        return $rules;
    }

    public function messages() {       

        return [
            'required' => 'Este campo é obrigatório.',
            'min' => 'Campo deve possuir no mínimo 3 caracteres.',
            'max' => 'Campo deve possuir no máximo 255 caracteres.',
            'unique' => 'O dado informado já existe.',
            'integer' => 'Campo somente números.',
            'email' => 'O dado informado não corresponde a um endereço de email válido.',
            'digits_between' =>  'O registro deve ter 11 ou 14 dígitos, para CPF ou CNPJ, respectivamente.',
            'digits' =>  'O telefone deve possuir 11 dígitos.',
            'string' => 'Campo de possuir somente letras.'
        ];        
    }
}
