<?php

namespace App\Http\Requests;

use App\Models\guardian;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ChildRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // عند التعديل يكون id اليتيم موجوداً في الراوت → نتجاهل صفّه في فحص التفرّد الخاص بالطفل
        $orphanId = $this->route('id');

        $orphanNationalIdUnique = Rule::unique('orphans', 'national_id');
        if ($orphanId) {
            $orphanNationalIdUnique->ignore($orphanId);
        }

        // جلب سجل الوصي المرتبط بحساب المستخدم الحالي والذي يمتلك رقم هوية غير فارغ مسجل مسبقاً
        $existingGuardian = guardian::where('user_id', Auth::id())
            ->whereNotNull('national_id')
            ->where('national_id', '!=', '')
            ->first();

        return [
            // 1. بيانات اليتيم (Orphan)
            'child_first_name'            => 'required|string|max:50',
            'child_full_name'             => 'required|string|max:150',
            'child_national_id'           => ['required', 'digits:9', $orphanNationalIdUnique], // هوية الطفل يجب أن تكون فريدة
            'child_birth_date'            => 'required|date|before:today',
            'child_age'                   => 'required|integer|min:0|max:18',
            'child_gender'                => 'required|in:male,female,ذكر,أنثى',
            'child_education_status'      => 'required|string|max:100',
            'child_presence_status'       => 'required|string|max:100',
            'child_health_status'         => 'required|string|max:100',
            'child_medical_needs'         => 'nullable|string',
            'child_story'                 => 'nullable|string',

            // الصور والملفات الخاصة بالطفل
            'child_photo'                 => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'child_birth_certificate'     => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:4096',

            // حقول الـ Checkboxes
            'badge_both_parents'          => 'nullable',
            'badge_lone_survivor'         => 'nullable',
            'badge_extreme_need'          => 'nullable',
            'badge_injured'               => 'nullable',
            'badge_chronic_disease'       => 'nullable',
            'legal_affirmation'           => 'accepted',

            // 2. بيانات الوصي (Guardian)
            'guardian_name'               => 'required|string|max:150',
            'guardian_national_id'        => [
                'required',
                'digits:9',
                function ($attribute, $value, $fail) use ($existingGuardian) {
                    // الفحص يطبق فقط إذا كان هناك رقم هوية قديم مُخزّن بالفعل للوصي وليس NULL
                    if ($existingGuardian && !empty($existingGuardian->national_id)) {
                        if ($value !== $existingGuardian->national_id) {
                            $fail('رقم الهوية غير صحيح، يجب إدخال رقم هوية الوصي المسجل لهذا الحساب.');
                        }
                    }
                }
            ],
            'guardian_birth_date'         => 'required|date|before:child_birth_date',
            'guardian_relationship'       => 'required|string|max:100',
            'guardian_marital_status'     => 'required|string|max:50',
            'guardian_health_status'      => 'required|string|max:100',
            'guardian_health_details'     => 'nullable|string',
            'family_income_source'        => 'nullable|string|max:150',
            'guardian_id_photo'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'guardian_legal_document'     => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:4096',

            // 3. بيانات الوالدين (Parents)
            'father_name'                 => 'required|string|max:150',
            'father_national_id'          => 'nullable|digits:9',
            'father_death_date'           => 'nullable|date|before_or_equal:today',
            'father_death_reason'         => 'nullable|string|max:250',
            'mother_alive'                => 'required|in:yes,no',
            'mother_death_date'           => 'nullable|required_if:mother_alive,no|date|before_or_equal:today',
            'mother_death_reason'         => 'nullable|required_if:mother_alive,no|string|max:250',
            'father_death_certificate'    => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:4096',
            'mother_death_certificate'    => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:4096',

            // 4. السكن والنزوح (Housing)
            'housing_type'                 => 'required|string|max:100',
            'housing_condition'            => 'required|string|max:100',
            'housing_damage_details'       => 'nullable|string',
            'original_city'                => 'required|string|max:100',
            'current_displacement_destination' => 'required|string|max:100',
            'current_address_details'      => 'required|string',

            // 5. البيانات المالية (Financial)
            'financial_entity'             => 'required|string|max:150',
            'account_holder_name'          => 'required|string|max:150',
            'iban_or_account_number'       => 'required|string|max:50',
            'family_financial_rating'      => 'required|in:حالة ضعيفة,حالة متوسطة,حالة جيدة',
        ];
    }

    /**
     * تخصيص أسماء الحقول باللغة العربية لتظهر في رسائل الخطأ بشكل مفهوم للمستخدم.
     */
    public function messages(): array
    {
        return [
            // 1. بيانات اليتيم (Orphan)
            'child_first_name.required'            => 'حقل اسم الطفل الأول مطلوب *',
            'child_first_name.string'              => 'يجب أن يكون اسم الطفل الأول نصاً *',
            'child_first_name.max'                 => 'اسم الطفل الأول طويل جداً (الحد الأقصى 50 حرفاً) *',

            'child_full_name.required'             => 'حقل الاسم الكامل للطفل مطلوب *',
            'child_full_name.string'               => 'يجب أن يكون الاسم الكامل للطفل نصاً *',
            'child_full_name.max'                  => 'الاسم الكامل للطفل طويل جداً (الحد الأقصى 150 حرفاً) *',

            'child_national_id.required'           => 'رقم هوية الطفل مطلوب *',
            'child_national_id.digits'             => 'رقم هوية الطفل يجب أن يكون 9 أرقام بالضبط *',
            'child_national_id.unique'             => 'رقم هوية الطفل هذا مسجل مسبقاً في النظام *',

            'child_birth_date.required'            => 'تاريخ ميلاد الطفل مطلوب *',
            'child_birth_date.date'                => 'يجب إدخال تاريخ ميلاد صحيح *',
            'child_birth_date.before'              => 'يجب أن يكون تاريخ الميلاد قبل اليوم *',

            'child_age.required'                   => 'عمر الطفل مطلوب *',
            'child_age.integer'                    => 'يجب أن يكون العمر رقماً صحيحاً *',
            'child_age.min'                        => 'عمر الطفل لا يمكن أن يكون أقل من 0 *',
            'child_age.max'                        => 'عمر الطفل لا يجب أن يتجاوز 18 سنة *',

            'child_gender.required'                => 'حقل جنس الطفل مطلوب *',
            'child_gender.in'                      => 'يرجى اختيار جنس صحيح للطفل  *',

            'child_education_status.required'      => 'الحالة التعليمية للطفل مطلوبة *',
            'child_education_status.max'           => 'حقل الحالة التعليمية طويل جداً *',

            'child_presence_status.required'       => 'حالة تواجد الطفل مطلوبة *',
            'child_presence_status.max'            => 'حقل حالة تواجد الطفل طويل جداً *',

            'child_health_status.required'         => 'الحالة الصحية للطفل مطلوبة *',
            'child_health_status.max'              => 'حقل الحالة الصحية طويل جداً *',

            'child_photo.image'                    => 'الملف المرفوع لصورة الطفل يجب أن يكون صورة فقط *',
            'child_photo.mimes'                    => 'امتداد صورة الطفل يجب أن يكون (jpeg, png, jpg) *',
            'child_photo.max'                      => 'حجم صورة الطفل يجب ألا يتجاوز 2 ميجابايت *',

            'child_birth_certificate.file'         => 'يجب رفع ملف صحيح لشهادة الميلاد *',
            'child_birth_certificate.mimes'        => 'امتداد شهادة الميلاد يجب أن يكون (pdf, jpeg, png, jpg) *',
            'child_birth_certificate.max'          => 'حجم ملف شهادة الميلاد يجب ألا يتجاوز 4 ميجابايت *',

            'legal_affirmation.accepted'           => 'يجب الموافقة على الإقرار والتعهد القانوني للمتابعة *',

            // 2. بيانات الوصي (Guardian)
            'guardian_name.required'               => 'اسم الوصي مطلوب *',
            'guardian_name.max'                    => 'اسم الوصي طويل جداً (الحد الأقصى 150 حرفاً) *',

            'guardian_national_id.required'        => 'رقم هوية الوصي مطلوب *',
            'guardian_national_id.digits'          => 'رقم هوية الوصي يجب أن يكون 9 أرقام بالضبط *',

            'guardian_birth_date.required'         => 'تاريخ ميلاد الوصي مطلوب *',
            'guardian_birth_date.date'             => 'تاريخ ميلاد الوصي غير صحيح *',
            'guardian_birth_date.before'           => 'تاريخ ميلاد الوصي يجب أن يكون قبل تاريخ ميلاد الطفل *',

            'guardian_relationship.required'       => 'صلة القرابة بالطفل مطلوبة *',
            'guardian_relationship.max'            => 'حقل صلة القرابة طويل جداً *',

            'guardian_marital_status.required'     => 'الحالة الاجتماعية للوصي مطلوبة *',

            'guardian_health_status.required'      => 'الحالة الصحية للوصي مطلوبة *',

            'guardian_id_photo.image'              => 'الملف المرفوع لهوية الوصي يجب أن يكون صورة *',
            'guardian_id_photo.mimes'              => 'امتداد صورة هوية الوصي يجب أن يكون (jpeg, png, jpg) *',
            'guardian_id_photo.max'                => 'حجم صورة هوية الوصي يجب ألا يتجاوز 2 ميجابايت *',

            'guardian_legal_document.file'         => 'يجب رفع ملف صحيح لصك الولاية/الوصاية *',
            'guardian_legal_document.mimes'        => 'امتداد ملف الوصاية يجب أن يكون (pdf, jpeg, png, jpg) *',
            'guardian_legal_document.max'          => 'حجم ملف الوصاية يجب ألا يتجاوز 4 ميجابايت *',

            // 3. بيانات الوالدين (Parents)
            'father_name.required'                 => 'اسم الأب مطلوب *',
            'father_name.max'                      => 'اسم الأب طويل جداً *',

            'father_national_id.digits'            => 'رقم هوية الأب يجب أن يكون 9 أرقام بالضبط *',

            'father_death_date.date'               => 'تاريخ وفاة الأب غير صحيح *',
            'father_death_date.before_or_equal'    => 'تاريخ وفاة الأب لا يمكن أن يكون في المستقبل *',

            'mother_alive.required'                => 'يرجى تحديد ما إذا كانت الأم على قيد الحياة أم لا *',
            'mother_alive.in'                      => 'القيمة المحددة لحالة الأم غير صحيحة *',

            'mother_death_date.required_if'        => 'تاريخ وفاة الأم مطلوب لأنها متوفية *',
            'mother_death_date.date'               => 'تاريخ وفاة الأم غير صحيح *',
            'mother_death_date.before_or_equal'    => 'تاريخ وفاة الأم لا يمكن أن يكون في المستقبل *',

            'mother_death_reason.required_if'      => 'سبب وفاة الأم مطلوب لأنها متوفية *',

            'father_death_certificate.mimes'       => 'امتداد شهادة وفاة الأب يجب أن يكون (pdf, jpeg, png, jpg) *',
            'father_death_certificate.max'         => 'حجم ملف شهادة وفاة الأب يجب ألا يتجاوز 4 ميجابايت *',

            'mother_death_certificate.mimes'       => 'امتداد شهادة وفاة الأم يجب أن يكون (pdf, jpeg, png, jpg) *',
            'mother_death_certificate.max'         => 'حجم ملف شهادة وفاة الأم يجب ألا يتجاوز 4 ميجابايت *',

            // 4. السكن والنزوح (Housing)
            'housing_type.required'                 => 'نوع السكن مطلوب *',
            'housing_condition.required'            => 'حالة السكن مطلوبة *',

            'original_city.required'                => 'المدينة الأصلية مطلوبة *',

            'current_displacement_destination.required' => 'مكان النزوح الحالي مطلوب *',

            'current_address_details.required'      => 'تفاصيل العنوان الحالي مطلوبة *',

            // 5. البيانات المالية (Financial)
            'financial_entity.required'             => 'جهة الاستلام المالية مطلوبة *',

            'account_holder_name.required'          => 'اسم صاحب الحساب المالي مطلوب *',

            'iban_or_account_number.required'       => 'رقم الحساب أو الآيبان مطلوب *',

            'family_financial_rating.required'      => 'التقييم المالي والوضع الاقتصادي للعائلة مطلوب *',
            'family_financial_rating.in'            => 'يرجى اختيار تقييم مالي صحيح من القائمة *',
        ];
    }
}
