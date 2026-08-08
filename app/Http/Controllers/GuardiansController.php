<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChildRequest;
use App\Models\AuditLog;
use App\Models\documents;
use App\Models\financial_data;
use App\Models\guardian;
use App\Models\Housing;
use App\Models\orphans;
use App\Models\Parents;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class GuardiansController extends Controller
{
    /**
     *  guardian folder .
     */
    /**
     *  guardian folder .
     */
    public function dashboard()
    {
        $user = Auth::user();

        // 1. جلب سجل الوصي الأول لتأكيد وجود سجل
        $guardian = $user->guardian ?? guardian::where('user_id', $user->id)->first();

        if (!$guardian) {
            return view('guardian.dashboard', [
                'user'                => $user,
                'guardian'            => null,
                'orphan'              => collect(),
                'childrenCount'       => 0,
                'activeSponsorships'  => 0,
                'requiredDocsCount'   => 0,
            ]);
        }

        // 2. جلب جميع معرفات الأطفال التابعين لهذا الوصي عبر user_id
        $orphanIds = guardian::where('user_id', $user->id)->pluck('orphan_id');

        // 3. جلب الأيتام بناءً على قائمة المعرفات كاملة
        $orphan = orphans::whereIn('id', $orphanIds)->get();

        // 4. حساب الأبناء المسجلين
        $childrenCount = $orphan->count();

        // 5. حساب عدد الكفالات النشطة لجميع الأبناء التابعين للوصي
        $activeSponsorships = orphans::whereIn('id', $orphanIds)
            ->whereIn('status', ['مكفول', 'كفالة نشطة', 'نشط'])
            ->count();

        // 6. حساب المستندات المطلوبة لجميع الأطفال
        $requiredDocsCount = documents::whereIn('orphan_id', $orphanIds)
            ->where('status', 'مطلوب')
            ->count();

        return view('guardian.dashboard', compact(
            'user',
            'guardian',
            'orphan',
            'childrenCount',
            'activeSponsorships',
            'requiredDocsCount'
        ));
    }
    /**
     *  guardian folder .
     *  children page .
     */
    public function children()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // 1. جلب جميع المعرفات (IDs) للأطفال التابعين لهذا المستخدم كوصي
        $orphanIds = guardian::where('user_id', $user->id)->pluck('orphan_id');

        // في حال عدم وجود أطفال مسجلين لهذا الوصي
        if ($orphanIds->isEmpty()) {
            return view('guardian.children', [
                'orphan'   => collect(),
                'document' => collect(),
                'user'     => $user
            ]);
        }

        // 2. جلب جميع الأطفال المقترنين بهذه المعرفات مع العلاقات المطلوبة
        $orphan = orphans::whereIn('id', $orphanIds)
            ->with(['guardian', 'parents', 'housing', 'financial_data'])
            ->get();

        // 3. جلب كافة المستندات التابعة لهؤلاء الأطفال
        // 3. جلب المستندات المقبولة فقط من الأدمن
        $document = documents::whereIn('orphan_id', $orphanIds)
            ->where('status', 'مقبول')
            ->get();

        return view('guardian.children', [
            'orphan'   => $orphan,
            'document' => $document,
            'user'     => $user
        ]);
    }

    public function child_form()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // جلب آخر بيانات وصي مسجلة لنفس هذا الحساب إن وجدت
        $existingGuardian = Guardian::where('user_id', $user->id)->latest()->first();
        $existingHousing = null;
        $existingFinancial = null;
        $existingParents = null;

        if ($existingGuardian) {
            $existingHousing = Housing::where('orphan_id', $existingGuardian->orphan_id)->first();
            $existingFinancial = financial_data::where('orphan_id', $existingGuardian->orphan_id)->first();
            $existingParents = Parents::where('orphan_id', $existingGuardian->orphan_id)->first();
        }

        $prefill = [
            // الوصي
            'guardian_name'           => $existingGuardian->name ?? $user->name,
            'guardian_national_id'    => $existingGuardian->national_id ?? '',
            'guardian_birth_date'     => isset($existingGuardian->birth_date) ? substr((string)$existingGuardian->birth_date, 0, 10) : '',
            'guardian_relationship'   => $existingGuardian->kinship_relation ?? '',
            'guardian_marital_status' => $existingGuardian->marital_status ?? '',
            'guardian_health_status'  => $existingGuardian->health_status ?? '',
            'guardian_health_details' => $existingGuardian->health_details ?? '',
            'family_income_source'    => $existingGuardian->income_source ?? '',

            // بيانات الأب (لأن الأبناء غالباً من نفس الأب)
            'father_name'         => $existingParents->name ?? '',
            'father_national_id'  => $existingParents->national_id ?? '',
            'father_death_date'   => isset($existingParents->death_date) ? substr((string)$existingParents->death_date, 0, 10) : '',
            'father_death_reason' => $existingParents->death_reason ?? '',
            'mother_alive'        => isset($existingParents) ? ($existingParents->is_mother_alive ? 'yes' : 'no') : 'yes',

            // السكن والنزوح (تتشارك فيه العائلة)
            'housing_type'                     => $existingHousing->current_housing_type ?? '',
            'housing_condition'                => $existingHousing->housing_condition ?? '',
            'housing_damage_details'           => $existingHousing->damage_description ?? '',
            'original_city'                    => $existingHousing->original_city ?? '',
            'current_displacement_destination' => $existingHousing->current_displacement_destination ?? '',
            'current_address_details'          => $existingHousing->detailed_current_address ?? '',

            // المالية (تتشارك فيها العائلة)
            'financial_entity'        => $existingFinancial->official_receiving_entity ?? '',
            'account_holder_name'     => $existingFinancial->account_holder_name ?? '',
            'iban_or_account_number'  => $existingFinancial->bank_account_or_iban ?? '',
        ];

        return view('guardian.child-form', [
            'user' => $user,
            'prefill' => $prefill
        ]);
    }

    // عرض نفس فورم الإنشاء لكن معبأ ببيانات اليتيم وعائلته (وضع التعديل)
    public function edit(string $id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        $orphan = orphans::with(['guardian', 'parents', 'housing', 'financial_data'])->findOrFail($id);
        $g = $orphan->guardian;
        $p = $orphan->parents;
        $h = $orphan->housing;
        $f = $orphan->financial_data;

        $genderMap = ['ذكر', 'أنثى'];
        $ratingMap = ['حالة ضعيفة',  'حالة متوسطة', 'حالة جيدة'];
        $d = fn($v) => $v ? substr((string) $v, 0, 10) : null; // تنسيق التاريخ لحقل input[type=date]

        // القيم المعبأة مسبقاً، مُحوّلة إلى أسماء حقول الفورم وتُمرَّر كمتغيّر صريح للـ view.
        // حقول الـ checkbox تُمثَّل بـ '1' عند التفعيل و '' عند عدمه لتتوافق مع old() في الفورم.
        $prefill = [
            // اليتيم
            'child_first_name'       => $orphan->first_name,
            'child_full_name'        => $orphan->name,
            'child_rating'           => $orphan->rating ?? 1, // جلب التقييم الرقمي المخزن بالجدول
            'child_national_id'      => $orphan->national_id,
            'child_birth_date'       => $d($orphan->birth_date),
            'child_age'              => $orphan->age,
            'child_gender'           => $genderMap[$orphan->gender] ?? $orphan->gender,
            'child_education_status' => $orphan->education_level,
            'child_presence_status'  => $orphan->orphan_location_status,
            'child_health_status'    => $orphan->health_status,
            'child_medical_needs'    => $orphan->health_description,
            'child_story'            => $orphan->story,
            'badge_both_parents'     => $orphan->is_double_orphan ? '1' : '',
            'badge_lone_survivor'    => $orphan->is_sole_breadwinner ? '1' : '',
            'badge_extreme_need'     => $orphan->is_critically_needy ? '1' : '',
            'badge_injured'          => $orphan->is_war_injured ? '1' : '',
            'badge_chronic_disease'  => $orphan->has_chronic_disease ? '1' : '',
            'legal_affirmation'      => $orphan->data_acknowledgement ? '1' : '',
            // الوصي
            'guardian_name'           => $g->name ?? null,
            'guardian_national_id'    => $g->national_id ?? null,
            'guardian_birth_date'     => $d($g->birth_date ?? null),
            'guardian_relationship'   => $g->kinship_relation ?? null,
            'guardian_marital_status' => $g->marital_status ?? null,
            'guardian_health_status'  => $g->health_status ?? null,
            'guardian_health_details' => $g->health_details ?? null,
            'family_income_source'    => $g->income_source ?? null,
            // الوالدين
            'father_name'         => $p->name ?? null,
            'father_national_id'  => $p->national_id ?? null,
            'father_death_date'   => $d($p->death_date ?? null),
            'father_death_reason' => $p->death_reason ?? null,
            'mother_alive'        => isset($p) ? ($p->is_mother_alive ? 'yes' : 'no') : 'yes',
            'mother_death_date'   => $d($p->mother_death_date ?? null),
            'mother_death_reason' => $p->mother_death_reason ?? null,
            // السكن
            'housing_type'                     => $h->current_housing_type ?? null,
            'housing_condition'                => $h->housing_condition ?? null,
            'housing_damage_details'           => $h->damage_description ?? null,
            'original_city'                    => $h->original_city ?? null,
            'current_displacement_destination' => $h->current_displacement_destination ?? null,
            'current_address_details'          => $h->detailed_current_address ?? null,
            // المالية
            'financial_entity'        => $f->official_receiving_entity ?? null,
            'account_holder_name'     => $f->account_holder_name ?? null,
            'iban_or_account_number'  => $f->bank_account_or_iban ?? null,
            'family_financial_rating' => isset($f) ? ($ratingMap[$f->family_financial_status] ?? null) : null,
        ];




        return view('guardian.child-form', ['editId' => $id, 'prefill' => $prefill, 'user' => $user]);
    }

    // حفظ تعديلات بيانات اليتيم وعائلته على نفس الجداول الخمسة
    public function update(ChildRequest $request, string $id)
    {
        $orphan = orphans::findOrFail($id);
        if (!$orphan) {
            return redirect()->route('login');
        }

        DB::beginTransaction();
        try {
            // 1) اليتيم
            $orphan->first_name = $request->child_first_name;
            $orphan->name = $request->child_full_name;
            // بدلاً من $request->child_financial_rating
            // في دالة update ودالة new_child_form
            $orphan->rating = $request->input('child_rating', 1);
            $orphan->national_id = $request->child_national_id;
            $orphan->birth_date = $request->child_birth_date;
            $orphan->age = $request->child_age;
            $genderMap = ['ذكر', 'أنثى'];
            $orphan->gender = $genderMap[$request->child_gender] ?? $request->child_gender;
            $orphan->education_level = $request->child_education_status;
            $orphan->orphan_location_status = $request->child_presence_status;
            $orphan->is_double_orphan = $request->has('badge_both_parents') ? 1 : 0;
            $orphan->is_sole_breadwinner = $request->has('badge_lone_survivor') ? 1 : 0;
            $orphan->is_critically_needy = $request->has('badge_extreme_need') ? 1 : 0;
            $orphan->is_war_injured = $request->has('badge_injured') ? 1 : 0;
            $orphan->has_chronic_disease = $request->has('badge_chronic_disease') ? 1 : 0;
            $orphan->health_status = $request->child_health_status;
            $orphan->health_description = $request->child_medical_needs;
            $orphan->story = $request->child_story;
            $orphan->data_acknowledgement = $request->has('legal_affirmation') ? 1 : 0;
            $orphan->city = $request->original_city ?? $orphan->city;

            if ($request->hasFile('child_photo')) {
                $fileName = 'orphan_' . time() . '_' . $request->child_first_name . '.' . $request->child_photo->extension();
                $request->child_photo->move(public_path('Uploads/orphans'), $fileName);
                $orphan->personal_photo_path = $fileName;
            }
            if ($request->hasFile('child_birth_certificate')) {
                $certName = 'birth_' . time() . '.' . $request->child_birth_certificate->extension();
                $request->child_birth_certificate->move(public_path('Uploads/certificates'), $certName);
                $orphan->birth_certificate_path = $certName;
            }
            $orphan->save();

            // 2) الوصي (نحدّث صفّه المرتبط أو ننشئه إن غاب)
            $guardian = guardian::firstOrNew(['orphan_id' => $orphan->id]);
            $guardian->name = $request->guardian_name;
            $guardian->national_id = $request->guardian_national_id;
            $guardian->birth_date = $request->guardian_birth_date;
            $guardian->kinship_relation = $request->guardian_relationship;
            $guardian->marital_status = $request->guardian_marital_status;
            $guardian->health_status = $request->guardian_health_status;
            $guardian->health_details = $request->guardian_health_details;
            $guardian->income_source = $request->family_income_source;
            $guardian->orphan_id = $orphan->id;
            if (!$guardian->exists) {
                $guardian->user_id = Auth::id();
            }
            if ($request->hasFile('guardian_id_photo')) {
                $gIdName = 'guardian_id_' . time() . '.' . $request->guardian_id_photo->extension();
                $request->guardian_id_photo->move(public_path('Uploads/guardians'), $gIdName);
                $guardian->guardian_id_image = $gIdName;
            } elseif (! $guardian->guardian_id_image) {
                $guardian->guardian_id_image = 'default.png';
            }
            if ($request->hasFile('guardian_legal_document')) {
                $gDocName = 'legal_doc_' . time() . '.' . $request->guardian_legal_document->extension();
                $request->guardian_legal_document->move(public_path('Uploads/guardians'), $gDocName);
                $guardian->legal_guardianship_document = $gDocName;
            } elseif (! $guardian->legal_guardianship_document) {
                $guardian->legal_guardianship_document = 'default.pdf';
            }
            $guardian->save();

            // 3) الوالدين
            $parent = Parents::firstOrNew(['orphan_id' => $orphan->id]);
            $parent->name = $request->father_name;
            $parent->national_id = $request->father_national_id;
            $parent->death_date = $request->father_death_date;
            $parent->death_reason = $request->father_death_reason;
            $parent->is_mother_alive = ($request->mother_alive == 'yes') ? 1 : 0;
            $parent->mother_death_date = $request->mother_death_date;
            $parent->mother_death_reason = $request->mother_death_reason;
            $parent->orphan_id = $orphan->id;
            if ($request->hasFile('father_death_certificate')) {
                $fDeath = 'father_death_' . time() . '.' . $request->father_death_certificate->extension();
                $request->father_death_certificate->move(public_path('Uploads/parents'), $fDeath);
                $parent->death_certificate = $fDeath;
            } elseif (! $parent->death_certificate) {
                $parent->death_certificate = 'default.pdf';
            }
            if ($request->hasFile('mother_death_certificate')) {
                $mDeath = 'mother_death_' . time() . '.' . $request->mother_death_certificate->extension();
                $request->mother_death_certificate->move(public_path('Uploads/parents'), $mDeath);
                $parent->mother_death_certificate = $mDeath;
            }
            $parent->save();

            // 4) السكن والنزوح
            $housing = Housing::firstOrNew(['orphan_id' => $orphan->id]);
            $housing->current_housing_type = $request->housing_type;
            $housing->housing_condition = $request->housing_condition;
            $housing->damage_description = $request->housing_damage_details;
            $housing->original_city = $request->original_city;
            $housing->current_displacement_destination = $request->current_displacement_destination;
            $housing->detailed_current_address = $request->current_address_details;
            $housing->orphan_id = $orphan->id;
            $housing->save();

            // 5) البيانات المالية
            $financial = financial_data::firstOrNew(['orphan_id' => $orphan->id]);
            $financial->official_receiving_entity = $request->financial_entity;
            $financial->account_holder_name = $request->account_holder_name;
            $financial->bank_account_or_iban = $request->iban_or_account_number;
            $statusMap = ['حالة ضعيفة' => 'weak', 'حالة متوسطة' => 'medium', 'حالة جيدة' => 'good'];
            $financial->family_financial_status = $statusMap[$request->family_financial_rating] ?? 'weak';
            $financial->orphan_id = $orphan->id;
            $financial->save();

            DB::commit();

            AuditLog::create([
                'user_id' => Auth::id(), // معرف الكفيل الذي قام بالتحديث
                'action'  => 'تعديل بيانات طفل',
                'details' => 'تم تحديث على بيانات الطفل ' . $orphan->name,
            ]);

            return redirect()->route('children')->with('success', 'تم تحديث بيانات اليتيم وعائلته بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('update child failed: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->withErrors(['error' => 'حدث خطأ أثناء التحديث: ' . $e->getMessage()]);
        }
    }

    // حذف اليتيم (ويُحذف معه تلقائياً الوصي والوالدين والسكن والبيانات المالية عبر cascade)
    public function destroy(string $id)
    {
        $orphan = orphans::findOrFail($id);
        if (!$orphan) {
            return redirect()->route('login');
        }
        $orphan->delete();

        AuditLog::create([
            'user_id' => Auth::id(), // معرف الكفيل الذي قام بالتحديث
            'action'  => 'حذف طفل',
            'details' => 'تم حذف الطفل ' . $orphan->name,
        ]);

        return redirect()->route('children')->with('success', 'تم حذف اليتيم وكافة بياناته المرتبطة بنجاح.');
    }

    /**
     *  guardian folder .
     *  children-form page .
     */

    public function new_child_form(ChildRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // استخدام الـ Transaction لضمان حفظ كل الجداول معاً أو تراجع الكل في حال حدوث خطأ
        DB::beginTransaction();

        try {
            // 1. حفظ بيانات اليتيم
            $orphan = new orphans(); // التأكد من اسم الموديل عندك
            $orphan->first_name = $request->child_first_name;
            $orphan->name = $request->child_full_name;
            $orphan->national_id = $request->child_national_id;
            $orphan->birth_date = $request->child_birth_date;
            $orphan->age = $request->child_age;

            // تحديد الجنس بدقة
            $genderMap = ['0' => 'ذكر', '1' => 'أنثى', 'ذكر' => 'ذكر', 'أنثى' => 'أنثى'];
            $orphan->gender = $genderMap[$request->child_gender] ?? $request->child_gender;

            $orphan->education_level = $request->child_education_status;
            $orphan->orphan_location_status = $request->child_presence_status;

            // حقول الـ Checkbox (تحويلها إلى Boolean)
            $orphan->is_double_orphan = $request->has('badge_both_parents') ? 1 : 0;
            $orphan->is_sole_breadwinner = $request->has('badge_lone_survivor') ? 1 : 0;
            $orphan->is_critically_needy = $request->has('badge_extreme_need') ? 1 : 0;
            $orphan->is_war_injured = $request->has('badge_injured') ? 1 : 0;
            $orphan->has_chronic_disease = $request->has('badge_chronic_disease') ? 1 : 0;
            // في دالة update ودالة new_child_form
            $orphan->rating = $request->input('child_rating', 1);

            $orphan->health_status = $request->child_health_status;
            $orphan->health_description = $request->child_medical_needs;
            $orphan->story = $request->child_story;
            $orphan->data_acknowledgement = $request->has('legal_affirmation') ? 1 : 0;

            // حقول إضافية مع قيم افتراضية
            $orphan->country = 'Palestine';
            $orphan->city = $request->original_city ?? 'Gaza';
            $orphan->status = 'بانتظار القبول';

            // رفع صورة الطفل الشخصية
            if ($request->hasFile('child_photo')) {
                $fileName = 'orphan_' . time() . '_' . $request->child_first_name . '.' . $request->child_photo->extension();
                $request->child_photo->move(public_path('Uploads/orphans'), $fileName);
                $orphan->personal_photo_path = $fileName;
            } else {
                $orphan->personal_photo_path = 'default.png';
            }

            // رفع شهادة ميلاد الطفل
            if ($request->hasFile('child_birth_certificate')) {
                $certName = 'birth_' . time() . '.' . $request->child_birth_certificate->extension();
                $request->child_birth_certificate->move(public_path('Uploads/certificates'), $certName);
                $orphan->birth_certificate_path = $certName;
            } else {
                $orphan->birth_certificate_path = 'default_cert.png';
            }

            $orphan->save(); // تم الحفظ وتوليد ID اليتيم

            // 2. حفظ بيانات الوصي (Guardian)
            $guardian = new Guardian();
            $guardian->orphan_id = $orphan->id; // ربط المفتاح الأجنبي
            $guardian->user_id = Auth::id();
            $guardian->name = $request->guardian_name;
            $guardian->national_id = $request->guardian_national_id;
            $guardian->birth_date = $request->guardian_birth_date;
            $guardian->kinship_relation = $request->guardian_relationship;
            $guardian->marital_status = $request->guardian_marital_status;
            $guardian->health_status = $request->guardian_health_status;
            $guardian->health_details = $request->guardian_health_details;
            $guardian->income_source = $request->family_income_source;

            // صورة هوية الوصي
            if ($request->hasFile('guardian_id_photo')) {
                $gIdName = 'guardian_id_' . time() . '.' . $request->guardian_id_photo->extension();
                $request->guardian_id_photo->move(public_path('Uploads/guardians'), $gIdName);
                $guardian->guardian_id_image = $gIdName;
            } else {
                $guardian->guardian_id_image = 'default.png';
            }

            // صك الوصاية القانوني
            if ($request->hasFile('guardian_legal_document')) {
                $gDocName = 'legal_doc_' . time() . '.' . $request->guardian_legal_document->extension();
                $request->guardian_legal_document->move(public_path('Uploads/guardians'), $gDocName);
                $guardian->legal_guardianship_document = $gDocName;
            } else {
                $guardian->legal_guardianship_document = 'default.pdf';
            }

            $orphan->guardian_id = $guardian->id;
            $guardian->save();

            // 3. حفظ بيانات الوالدين (Parents)
            $parent = new Parents();
            $parent->orphan_id = $orphan->id;
            $parent->name = $request->father_name;
            $parent->national_id = $request->father_national_id;
            $parent->death_date = $request->father_death_date;
            $parent->death_reason = $request->father_death_reason;
            $parent->is_mother_alive = ($request->mother_alive == 'yes') ? 1 : 0;
            $parent->mother_death_date = $request->mother_death_date;
            $parent->mother_death_reason = $request->mother_death_reason;

            if ($request->hasFile('father_death_certificate')) {
                $fDeath = 'father_death_' . time() . '.' . $request->father_death_certificate->extension();
                $request->father_death_certificate->move(public_path('Uploads/parents'), $fDeath);
                $parent->death_certificate = $fDeath;
            } else {
                $parent->death_certificate = 'default.pdf';
            }

            if ($request->hasFile('mother_death_certificate')) {
                $mDeath = 'mother_death_' . time() . '.' . $request->mother_death_certificate->extension();
                $request->mother_death_certificate->move(public_path('Uploads/parents'), $mDeath);
                $parent->mother_death_certificate = $mDeath;
            }

            $parent->save();

            // 4. حفظ بيانات السكن والنزوح (Housing)
            $housing = new Housing();
            $housing->orphan_id = $orphan->id;
            $housing->current_housing_type = $request->housing_type;
            $housing->housing_condition = $request->housing_condition;
            $housing->damage_description = $request->housing_damage_details;
            $housing->original_city = $request->original_city;
            $housing->current_displacement_destination = $request->current_displacement_destination;
            $housing->detailed_current_address = $request->current_address_details;
            $housing->save();

            // 5. حفظ البيانات المالية (Financial Data)
            $financial = new financial_data();
            $financial->orphan_id = $orphan->id;
            $financial->official_receiving_entity = $request->financial_entity;
            $financial->account_holder_name = $request->account_holder_name;
            $financial->bank_account_or_iban = $request->iban_or_account_number;

            $statusMap = ['حالة ضعيفة' => 'weak', 'حالة متوسطة' => 'medium', 'حالة جيدة' => 'good'];
            $financial->family_financial_status = $statusMap[$request->family_financial_rating] ?? 'weak';
            $financial->save();

            // تأكيد الحفظ الفعلي بقاعدة البيانات لجميع الجداول
            DB::commit();

            AuditLog::create([
                'user_id' => Auth::id(),
                'action'  => 'إضافة طفل جديد',
                'details' => 'تم إضافة طفل جديد باسم: ' . $orphan->name,
            ]);

            return redirect()->route('children')->with('success', 'تم إضافة الطفل بنجاح وتوزيع البيانات على الجداول.');
        } catch (\Exception $e) {
            // إلغاء المعاملة عند حدوث أي خطأ
            DB::rollBack();

            Log::error('new_child_form failed: ' . $e->getMessage(), ['exception' => $e]);

            return redirect()->back()->withInput()->withErrors(['error' => 'حدث خطأ أثناء الحفظ: ' . $e->getMessage()]);
        }
    }

    /**
     *  guardian folder .
     *  upload_docs page .
     */

    public function upload_docs()
    {
        $user = Auth::user();

        // 1. جلب معرفات جميع الأطفال التابعين لهذا المستخدم
        $orphanIds = guardian::where('user_id', $user->id)->pluck('orphan_id');

        if ($orphanIds->isEmpty()) {
            return view('guardian.upload-docs', [
                'orphan' => collect(),
                'user'   => $user
            ]);
        }

        // 2. جلب كافة الأطفال المعنيين لإظهارهم في القائمة المنسدلة
        $orphan = orphans::whereIn('id', $orphanIds)->get();

        return view('guardian.upload-docs', [
            'orphan' => $orphan,
            'user'   => $user
        ]);
    }

    public function upload_docs_store(Request $request)
    {
        // 1. التحقق لضمان وصول البيانات كاملة ومنع الأخطاء
        $request->validate([
            'orphan_id' => 'required',
            'doc_type'  => 'required',
            'title'     => 'required',
            'document'  => 'required|file|max:4096',
        ]);

        $document = new documents;
        $document->title = $request->title;
        $document->doc_type = $request->doc_type;
        $document->orphan_id = $request->orphan_id;
        $document->date = now()->format('Y-m-d');

        // 2. معالجة وحفظ الملف المرفوع واستخراج البيانات منه لقاعدة البيانات
        // 2. معالجة وحفظ الملف المرفوع واستخراج البيانات منه لقاعدة البيانات
        if ($request->hasFile('document')) {
            $file = $request->file('document');

            // 1. توليد اسم فريد للملف
            $d = 'document_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // 2. جلب البيانات وحفظها في الكائن (فقط الحقول الموجودة في قاعدة البيانات)
            $document->file_path = 'Uploads/document/' . $d;

            // 3. نقل الملف الفعلي إلى المجلد المطلوب
            $file->move(public_path('Uploads/document'), $d);
        }

        AuditLog::create([
            'user_id' => Auth::id(), // معرف الكفيل الذي قام بالتحديث
            'action'  => 'اضافة مستندات',
            'details' => 'تم اضافة مستند من نوع ' . $request->doc_type . ' لصالح الطفل ' . $request->orphan_id,
        ]);

        // 3. الحفظ الفعلي في قاعدة البيانات
        $document->save();

        // 4. إعادة التوجيه لصفحة الأطفال مع رسالة نجاح
        return redirect()->route('children')->with('success', 'تم رفع المستند بنجاح وهو قيد المراجعة الآن.');
    }

    /**
     *  guardian folder .
     *  upload_docs page .
     */

    public function received_payments()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // 1. جلب سجل الوصي
        $guardian = guardian::where('user_id', $user->id)->first();

        if (!$guardian || !$guardian->orphan_id) {
            return view('guardian.received-payments', [
                'user' => $user,
                'payments' => collect(),
                'totalReceived' => 0,
                'paymentsCount' => 0
            ]);
        }

        // 2. الاستعلام من جدول الكفالات والمدفوعات الحقيقي (sponsorships)
        $orphanId = $guardian->orphan_id;
        $query = Sponsorship::where('orphan_id', $orphanId);

        // 3. جلب المدفوعات مع اليتيم مرقمة صفحتها
        $payments = (clone $query)
            ->with(['orphan'])
            ->latest()
            ->paginate(10);

        // 4. إجمالي عدد الحوالات الموجهة للطفل
        $paymentsCount = $payments->total();

        // 5. حساب إجمالي المبالغ "المقبوضة والمؤكدة" فقط (payment_status == 'paid')
        $totalReceived = (clone $query)
            ->where('payment_status', 'paid')
            ->sum('amount_paid');

        return view('guardian.received-payments', compact('user', 'payments', 'totalReceived', 'paymentsCount'));
    }


    /**
     * عرض صفحة الإشعارات الخاصة بالوصي
     */
    public function notifications()
    {
        $user = Auth::user();

        // جلب إشعارات الوصي/الأمهات الحاضنات مرتبة أحدثها أولاً مع Pagination
        $notifications = $user->notifications()->latest()->paginate(10);

        return view('guardian.notifications', compact('user', 'notifications'));
    }

    /**
     * تعليم جميع إشعارات الوصي كمقروءة
     */
    public function markAllRead()
    {
        try {
            $user = Auth::user();

            // تعليم الإشعارات غير المقروءة كمقروءة
            $user->unreadNotifications->markAsRead();

            return redirect()->back()->with('success', 'تم تعليم جميع الإشعارات كمقروءة بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث حالة الإشعارات.');
        }
    }


    public function profile()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        return view('guardian.profile', ['user' => $user]);
    }

    public function updateProfileFields(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // 1. التحقق من صحة البيانات
        $request->validate([
            'name'                             => 'nullable|string|max:255',
            'email'                            => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'phone'                            => 'nullable|string|unique:users,phone,' . $user->id,
            'current_displacement_destination' => 'nullable|string|max:255',
            'health_status'                    => 'nullable|string|max:500',
            'profile_photo'                    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // 2. تحديث جدول users
        if ($request->filled('name')) {
            $user->name = $request->name;
        }
        if ($request->filled('email')) {
            $user->email = $request->email;
        }
        if ($request->filled('phone')) {
            $user->phone = $request->phone;
        }
        $user->save();

        // 3. تحديث بيانات الوصي
        if ($user->guardian) {
            $guardian = $user->guardian;

            // رفع وتحديث الصورة الشخصية للوصي
            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $filename = 'guardian_avatar_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('Uploads/guardians'), $filename);

                // الاعتماد على العمود الصحيح image بدلاً من guardian_id_image
                $guardian->image = $filename;
            }

            if ($request->filled('name')) {
                $guardian->name = $request->name;
            }

            if ($request->has('health_status')) {
                $guardian->health_status = $request->health_status;
            }

            $guardian->save();

            // تحديث جدول السكن (Housing)
            if ($request->has('current_displacement_destination')) {
                $housing = Housing::firstOrNew([
                    'orphan_id' => $guardian->orphan_id
                ]);

                $housing->guardian_id = $guardian->id;
                $housing->current_displacement_destination = $request->current_displacement_destination;
                $housing->current_housing_type = $housing->current_housing_type ?? 'غير محدد';
                $housing->housing_condition    = $housing->housing_condition ?? 'غير محدد';

                $housing->save();

                AuditLog::create([
                    'user_id' => Auth::id(), // معرف الكفيل الذي قام بالتحديث
                    'action'  => 'تعديل بيانات وصي',
                    'details' => 'قام الوصي بتحديث بيانته الشخصية ',
                ]);
            }
        }

        return redirect()->back()->with('success', 'تم تحديث البيانات والصورة بنجاح!');
    }

    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // التحقق من شروط كلمة المرور وتأكيدها
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'يرجى إدخال كلمة المرور الحالية',
            'password.confirmed'        => 'كلمة المرور الجديدة غير مطابقة للتأكيد',
            'password.min'              => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
        ]);

        // التحقق من أن كلمة المرور الحالية صحيحة
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
        }

        // تشفير وحفظ كلمة المرور الجديدة
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'تم تغيير كلمة المرور بنجاح!');
    }
}
