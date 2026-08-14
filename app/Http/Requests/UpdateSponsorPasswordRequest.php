<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSponsorPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => 'required',
            'password'         => 'required|string|min:6|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'حقل كلمة المرور الحالية مطلوب ولا يمكن تركه فارغاً.',
            'password.required'         => 'يرجى إدخال كلمة المرور الجديدة.',
            'password.min'              => 'يجب ألا تقل كلمة المرور الجديدة عن 6 رموز.',
            'password.confirmed'        => 'تأكيد كلمة المرور الجديدة غير متطابق مع الحقل السابق.',
        ];
    }
}
