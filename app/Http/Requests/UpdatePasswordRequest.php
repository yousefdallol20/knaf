<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => 'required|string',
            'password'         => 'required|string|min:6|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'يرجى إدخال كلمة المرور الحالية *',
            'password.required'         => 'يرجى إدخال كلمة المرور الجديدة *',
            'password.min'              => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل *',
            'password.confirmed'        => 'كلمة المرور الجديدة غير مطابقة للتأكيد *',
        ];
    }
}
