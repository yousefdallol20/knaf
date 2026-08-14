<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessSponsorshipStep3Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method'        => 'required|in:card,bank_transfer',
            'amount_paid'           => 'required|numeric|min:1',
            'orphan_id'             => 'required|exists:orphans,id',
            'bank_reference_number' => 'required_if:payment_method,bank_transfer',
            'bank_receipt_file'     => 'required_if:payment_method,bank_transfer|nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'transaction_id'        => 'required_if:payment_method,card',
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required'        => 'يرجى اختيار طريقة الدفع المناسبة *',
            'payment_method.in'              => 'طريقة الدفع المحددة غير مدعومة *',
            'amount_paid.required'           => 'قيمة المبلغ الدعم مطلوبة *',
            'amount_paid.numeric'            => 'قيمة الدفع يجب أن تكون رقماً *',
            'amount_paid.min'                => 'أقل قيمة إيداع مسموح بها هي 1 $ *',
            'orphan_id.required'             => 'رقم اليتيم مطلوب لإتمام العملية *',
            'bank_reference_number.required_if' => 'يرجى إدخال رقم الحوالة أو المرجع البنكي *',
            'bank_receipt_file.required_if'     => 'يرجى إرفاق صورة أو ملف إشعار التحويل البنكي *',
            'bank_receipt_file.mimes'           => 'صيغ الملفات المقبولة هي: jpeg, png, jpg, pdf *',
            'bank_receipt_file.max'             => 'حجم الملف أقصاه 2 ميجابايت *',
            'transaction_id.required_if'        => 'رمز عملية الدفع الإلكتروني مطلوب *',
        ];
    }
}
