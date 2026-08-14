<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGuardianProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'name'                             => 'nullable|string|max:255',
            'email'                            => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'phone'                            => ['nullable', 'string', Rule::unique('users', 'phone')->ignore($userId)],
            'current_displacement_destination' => 'nullable|string|max:255',
            'health_status'                    => 'nullable|string|max:500',
            'profile_photo'                    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'email.email'         => 'صيغة البريد الإلكتروني غير صحيحة *',
            'email.unique'        => 'البريد الإلكتروني مُستخدَم بالفعل لحساب آخر *',
            'phone.unique'        => 'رقم الهاتف مُستخدَم بالفعل لحساب آخر *',
            'profile_photo.image' => 'الملف المرفوع يجب أن يكون صورة *',
            'profile_photo.mimes' => 'امتداد الصورة غير مدعوم (jpeg, png, jpg, gif, webp) *',
            'profile_photo.max'   => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت *',
        ];
    }
}
