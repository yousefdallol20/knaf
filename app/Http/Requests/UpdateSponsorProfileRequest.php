<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSponsorProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->user();
        $sponsorId = $user->sponsor->id ?? null;

        return [
            'name'          => 'required|string|max:255',
            'email'         => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
                Rule::unique('sponsors', 'email')->ignore($sponsorId),
            ],
            'phone'         => [
                'required',
                'string',
                Rule::unique('users', 'phone')->ignore($user->id),
                Rule::unique('sponsors', 'phone')->ignore($sponsorId),
            ],
            'country'       => 'required|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'          => 'يرجى إدخال اسم الكافل بالكامل.',
            'name.string'            => 'يجب أن يكون الاسم عبارة عن نص صحيح.',
            'name.max'               => 'يجب ألا يتجاوز الاسم 255 حرفاً.',
            'email.required'         => 'البريد الإلكتروني مطلوب ولا يمكن تركه فارغاً.',
            'email.email'            => 'يرجى إدخال بريد إلكتروني صيغته صحيحة (مثال: example@mail.com).',
            'email.unique'           => 'البريد الإلكتروني مُستخدم بالفعل من قِبل حساب آخر في النظام.',
            'phone.required'         => 'رقم الهاتف مطلوب ولا يمكن تركه فارغاً.',
            'phone.unique'           => 'رقم الجوال هذا مسجل مسبقاً لكافل أو مستخدم آخر في قاعدة البيانات.',
            'country.required'       => 'يرجى إدخال دولة أو مدينة الإقامة الفعلية.',
            'profile_photo.image'    => 'الملف المرفوع يجب أن يكون صورة فقط.',
            'profile_photo.mimes'    => 'صيغ الصور المدعومة هي فقط: jpeg, png, jpg, gif, webp.',
            'profile_photo.max'      => 'حجم الصورة الشخصية يجب ألا يتجاوز 2 ميجابايت.',
        ];
    }
}
