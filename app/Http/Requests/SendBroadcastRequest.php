<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendBroadcastRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'     => 'required|string|max:255',
            'user_type' => 'required|string',
            'type'      => 'required|string',
            'body'      => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'     => 'عنوان الإشعار مطلوب.',
            'user_type.required' => 'يرجى تحديد الفئة المستهدفة من الإشعار.',
            'type.required'      => 'يرجى اختيار نوع التنبيه.',
            'body.required'      => 'محتوى الإشعار مطلوب ولا يمكن تركه فارغاً.',
        ];
    }
}
