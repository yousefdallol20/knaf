<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RejectOrphanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reject_reason' => 'required|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'reject_reason.required' => 'يرجى كتابة سبب رفض الطلب لوضعه في الإشعار الموجه للوصي.',
            'reject_reason.string'   => 'سبب الرفض يجب أن يكون نصاً مكتوباً.',
            'reject_reason.max'      => 'سبب الرفض طويل جداً، يرجى اختصاره في حدود 500 حرف.',
        ];
    }
}
