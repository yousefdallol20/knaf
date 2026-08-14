<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApproveOrphanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'required_amount' => 'required|numeric|min:10',
        ];
    }

    public function messages(): array
    {
        return [
            'required_amount.required' => 'حقل مبلغ الكفالة المطلوب أمري ولا يمكن تركه فارغاً.',
            'required_amount.numeric'  => 'مبلغ الكفالة يجب أن يكون رقماً صحيحاً أو عشرياً.',
            'required_amount.min'      => 'أقل قيمة مسموحة لمبلغ الكفالة هي 10 دولار.',
        ];
    }
}
