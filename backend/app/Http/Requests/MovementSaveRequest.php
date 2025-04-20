<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;


class MovementSaveRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     */
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
            'id' => 'unique:movements,id,'.(isset($this->stockMovement) ? $this->stockMovement : null).',id',            
            'order_id' => 'nullable|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'movement_reason_id' => 'required|exists:movement_reasons,id',
            'quantity' => 'required|integer'
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

    public function messages(): array {       

        return [
            'required' => 'Este campo é obrigatório.',
            'unique' => 'O dado informado já existe.',
            'exists' => 'O dado informado não existe.',
            'decimal' => 'Este campo deve ter valor monetário. Ex.: 99999,00',
            'integer' => 'Este campo deve ser um inteiro.'
        ];        
    }
}