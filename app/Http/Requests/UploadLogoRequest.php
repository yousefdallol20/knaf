<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadLogoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'org_logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'org_logo.required' => 'يرجى اختيار ملف الشعار أولاً.',
            'org_logo.image'    => 'الملف المرفوع يجب أن يكون صورة.',
            'org_logo.mimes'    => 'صيغ الصور المسموحة هي: jpeg, png, jpg.',
            'org_logo.max'      => 'حجم صورة الشعار لا يجب أن يتجاوز 2 ميجابايت.',
        ];
    }
}
