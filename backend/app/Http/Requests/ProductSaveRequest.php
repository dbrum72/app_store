<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProductSaveRequest extends FormRequest {

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
            'id' => 'unique:products,id,'.(isset($this->product) ? $this->product : null).',id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|min:3|max:255',
            'description' => 'required',
            'price' => 'required|decimal:2',
            'barcode' => 'nullable|digits_between:13,15|unique:products,barcode,'.(isset($this->product) ? $this->product : null).',id'
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
            'min' => 'Este campo deve possuir no mínimo 3 caracteres.',
            'max' => 'Este campo deve possuir no máximo 255 caracteres.',
            'decimal' => 'Este campo deve ter valor monetário. Ex.: 99999,00',
            'digits_between' => 'Este campo deve ter entre 13 e 15 dígitos.',
            'mimes' => 'Este campo deve ser um arquivo do tipo: jpg, jpeg ou png.'
        ];        
    }

    protected function prepareForValidation(): void {

        $this->merge([
            'price' => Str::replace(',', '', number_format((float)Str::replace(',', '.',$this->price), 2))
        ]);
    }
}
