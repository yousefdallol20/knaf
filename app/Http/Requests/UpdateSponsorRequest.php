<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSponsorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $sponsorId = $this->route('id');

        return [
            'name'    => 'required|string|max:255',
            'email'   => ['required', 'email', Rule::unique('sponsors', 'email')->ignore($sponsorId)],
            'phone'   => ['required', 'string', Rule::unique('sponsors', 'phone')->ignore($sponsorId)],
            'country' => 'nullable|string|max:255',
            'city'    => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'اسم الكافل مطلوب.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email'    => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.unique'   => 'هذا البريد الإلكتروني مسجل مسبقاً لكافل آخر.',
            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.unique'   => 'رقم الهاتف هذا مسجل مسبقاً لكافل آخر.',
        ];
    }
}
