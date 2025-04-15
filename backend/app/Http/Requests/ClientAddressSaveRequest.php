<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientAddressSaveRequest extends FormRequest {

    public function authorize(): bool {

        return true;
    }

    /** @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> */

    public function rules() {
        
        $rules = [
            'id' => 'unique:clients_addresses,id,'.(isset($this->client_address) ? $this->client_address : null).',id',
            'street' => 'required|min:3|max:255',
            'complement' => 'nullable|min:3|max:255',
            'district' => 'required|min:3|max:255',
            'city' => 'required|min:3|max:255',
            'zipcode' => 'nullable|digits:8',
            'client_id' => 'required|exists:clients,id'
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
            'exists' => 'O dado informado não existe.',
            'digits' => 'o CEP deve possuir 8 dígitos',
        ];        
    }
}
