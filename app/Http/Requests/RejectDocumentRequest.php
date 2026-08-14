<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RejectDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rejection_reason' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'rejection_reason.max' => 'سبب رفض المستند يجب ألا يتجاوز 500 حرف.',
        ];
    }
}
