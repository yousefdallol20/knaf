<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessSponsorshipStep2Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'orphan_id' => 'required|exists:orphans,id',
            'name'      => 'required|string|max:255',
            'country'   => 'required|string|max:255',
            'city'      => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'orphan_id.required' => 'معرف اليتيم مطلوب *',
            'orphan_id.exists'   => 'سجل اليتيم المختار غير موجود بالمنظومة *',
            'name.required'      => 'يرجى إدخال اسم الكافل الكامل *',
            'name.string'        => 'الاسم يجب أن يكون نصاً صحيحاً *',
            'name.max'           => 'الاسم طويل جداً *',
            'country.required'   => 'يرجى تحديد دولة الإقامة *',
            'city.required'      => 'يرجى إدخال المدينة *',
        ];
    }
}
