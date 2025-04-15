<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientSaveRequest extends FormRequest {

    public function authorize(): bool {

        return true;
    }

    /** @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> */

    public function rules() {
        
        $rules = [
            'id' => 'unique:clients,id,'.(isset($this->client) ? $this->client : null).',id',
            'name' => 'required|min:3|max:255',
            'cnpj_cpf' => 'required|digits_between:11,14|unique:clients,cnpj_cpf,'.$this->client.',id',
            'email' => 'nullable|email:rfc,dns|unique:clients,email,'.$this->client.',id',
            'celphone' => 'nullable|digits:11'
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
        ];        
    }
}
