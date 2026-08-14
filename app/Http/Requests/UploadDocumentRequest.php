<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'orphan_id' => 'required|exists:orphans,id',
            'doc_type'  => 'required|string|max:100',
            'title'     => 'required|string|max:255',
            'document'  => 'required|file|mimes:pdf,jpeg,png,jpg|max:4096',
        ];
    }

    public function messages(): array
    {
        return [
            'orphan_id.required' => 'يرجى اختيار الطفل المراد رفع المستند له *',
            'orphan_id.exists'   => 'الطفل المختار غير موجود بالسجلات *',
            'doc_type.required'  => 'يرجى تحديد نوع المستند *',
            'title.required'     => 'عنوان المستند مطلوب *',
            'document.required'  => 'يرجى اختيار ملف المستند لرفعه *',
            'document.file'      => 'الملف المرفوع غير صالح *',
            'document.mimes'     => 'نوع الملف غير مدعوم، الامتدادات المسموحة: (pdf, jpeg, png, jpg) *',
            'document.max'       => 'حجم الملف يجب ألا يتجاوز 4 ميجابايت *',
        ];
    }
}
