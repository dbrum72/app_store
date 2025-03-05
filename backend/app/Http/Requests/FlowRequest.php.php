<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlowRequest extends FormRequest {

    
    public function authorize(): bool {

        return true;
    }

    
    public function rules(): array {

        return [
            'flow' => 'required|min:3|max:10',
        ];
    }
}
