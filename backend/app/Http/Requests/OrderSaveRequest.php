<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderSaveRequest extends FormRequest {

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
            'id' => 'unique:orders,id,'.(isset($this->order) ? $this->order : null).',id',
            'user_id' => 'required|exists:users,id',
            'client_id' => 'nullable|exists:clients,id',
            'order_progress_id' => 'required|exists:orders_progress,id'
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

    public function messages() {       

        return [
            'required' => 'Este campo é obrigatório.',
            'exists' => 'O dado informado não existe.'
        ];        
    }
}
