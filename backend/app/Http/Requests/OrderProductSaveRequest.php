<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderProductSaveRequest extends FormRequest {

    public function authorize(): bool {

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {

        $rules = [
            'order_id' => 'required|exists:pedidos,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|digits_between:1,5',
            'valor' => 'required|decimal:2',
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
            'exists' => 'O dado informado não existe.',
            'digits_between' => 'Este campo deve ter entre 1 e 5 dígitos.',
            'decimal' => 'Este campo deve ter valor monetário.'
        ];        
    }
}
