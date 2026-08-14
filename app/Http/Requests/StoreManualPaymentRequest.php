<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManualPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'orphan_id'      => 'required|exists:orphans,id',
            'amount_paid'    => 'required|numeric|min:1',
            'payment_method' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'orphan_id.required'      => 'يرجى اختيار اليتيم المكفول *',
            'orphan_id.exists'        => 'اليتيم المحدد غير موجود بالسجلات *',
            'amount_paid.required'    => 'يرجى تحديد المبلغ المراد دفعه *',
            'amount_paid.numeric'     => 'قيمة المبلغ يجب أن تكون رقماً *',
            'amount_paid.min'         => 'أقل مبلغ مسموح به هو 1 *',
            'payment_method.required' => 'يرجى تحديد طريقة الدفع *',
        ];
    }
}
