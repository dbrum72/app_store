<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategorySaveRequest extends FormRequest {

    public function authorize(): bool {

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {

        return [
            'id' => 'unique:categories,id,'.(isset($this->category) ? $this->category : null).',id',
            'parent_id' => 'nullable|exists:categories,id',
            'name' => 'required|min:3|max:25|unique:categories,name,'.(isset($this->category) ? $this->category : null).',id',
            'tree' => 'nullable'
        ];
    }

    public function messages() {       

        return [
            'required' => 'Este campo é obrigatório.',
            'unique' => 'O dado informado já existe.',
            'exists' => 'O dado informado não existe.',
            'min' => 'Campo deve possuir no mínimo 3 caracteres.',
            'max' => 'Campo deve possuir no máximo 25 caracteres.',
        ];        
    }
}
