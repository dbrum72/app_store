<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;


class StockSaveRequest extends FormRequest {

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
            'id' => 'unique:stocks,id,'.(isset($this->stock) ? $this->stock : null).',id',
            'operation_id' => 'required|exists:stock_operations,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'price' => 'required|decimal:2'
        ];

        if($this->method() === 'PATCH') {

            $dinamicRules = [];

            foreach($rules as $input => $rule) {

                if(array_key_exists($input, $this->request->all())) {

                    $dinamicRules[$input] = $rule;
                }
            }
        } else {
            $dinamicRules = $rules;
        }

        return $dinamicRules;       
    }

    public function messages(): array {       

        return [
            'required' => 'Este campo é obrigatório.',
            'unique' => 'O dado informado já existe.',
            'exists' => 'O dado informado não existe.',
            'decimal' => 'Este campo deve ter valor monetário. Ex.: 99999,00'
        ];        
    }

    protected function prepareForValidation(): void {

        $this->merge([
            'price' => Str::replace(',', '', number_format((float)Str::replace(',', '.',$this->price), 2))
        ]);
    }

}