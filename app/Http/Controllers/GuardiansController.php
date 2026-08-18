<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChildRequest;
use App\Http\Requests\UploadDocumentRequest;
use App\Http\Requests\UpdateGuardianProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\AuditLog;
use App\Models\documents;
use App\Models\financial_data;
use App\Models\Guardian;
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
     * لوحة تحكم الوصي - عرض إحصائيات لجميع الأطفال
     */
    public function dashboard()
    {
        $user = Auth::user();

        // 1. جلب سجل الوصي المنسوب للمستخدم الحالي
        $guardian = Guardian::where('user_id', $user->id)->first();

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

        // 2. جلب جميع الأيتام التابعين لهذا الوصي عبر guardian_id
        $orphan = orphans::where('guardian_id', $guardian->id)->get();
        $orphanIds = $orphan->pluck('id');

        // 3. حساب إجمالي عدد الأبناء
        $childrenCount = $orphan->count();

        // 4. حساب عدد الكفالات النشطة لجميع الأبناء
        $activeSponsorships = orphans::whereIn('id', $orphanIds)
            ->whereIn('status', ['مكفول', 'كفالة نشطة', 'نشط'])
            ->count();

        // 5. حساب المستندات المطلوبة لجميع الأطفال
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
     * عرض قائمة جميع الأبناء المسجلين للوصي
     */
    public function children()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $guardian = Guardian::where('user_id', $user->id)->first();

        if (!$guardian) {
            return view('guardian.children', [
                'orphan'   => collect(),
                'document' => collect(),
                'user'     => $user
            ]);
        }

        // جلب جميع الأطفال المنسوبين لهذا الوصي
        $orphan = orphans::where('guardian_id', $guardian->id)
            ->with(['guardian', 'parents', 'housing', 'financial_data'])
            ->get();

        $orphanIds = $orphan->pluck('id');

        // جلب المستندات المقبولة الخاصة بكل أطفاله
        $document = documents::whereIn('orphan_id', $orphanIds)
            ->where('status', 'مقبول')
            ->get();

        return view('guardian.children', [
            'orphan'   => $orphan,
            'document' => $document,
            'user'     => $user
        ]);
    }

    /**
     * نموذج إضافة طفل جديد مع التعبئة التلقائية لبيانات العائلة السابقة
     */
    public function child_form()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $existingGuardian = Guardian::where('user_id', $user->id)->first();
        $existingHousing = null;
        $existingFinancial = null;
        $existingParents = null;

        // في حال كان للوصي أطفال سابقون، يتم استعراض بيانات العائلة المترابطة لتسهيل الإدخال
        if ($existingGuardian) {
            $latestOrphan = orphans::where('guardian_id', $existingGuardian->id)->latest()->first();
            if ($latestOrphan) {
                $existingHousing = Housing::where('orphan_id', $latestOrphan->id)->first();
                $existingFinancial = financial_data::where('orphan_id', $latestOrphan->id)->first();
                $existingParents = Parents::where('orphan_id', $latestOrphan->id)->first();
            }
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

            // بيانات الأب
            'father_name'         => $existingParents->name ?? '',
            'father_national_id'  => $existingParents->national_id ?? '',
            'father_death_date'   => isset($existingParents->death_date) ? substr((string)$existingParents->death_date, 0, 10) : '',
            'father_death_reason' => $existingParents->death_reason ?? '',
            'mother_alive'        => isset($existingParents) ? ($existingParents->is_mother_alive ? 'yes' : 'no') : 'yes',

            // السكن والنزوح
            'housing_type'                     => $existingHousing->current_housing_type ?? '',
            'housing_condition'                => $existingHousing->housing_condition ?? '',
            'housing_damage_details'           => $existingHousing->damage_description ?? '',
            'original_city'                    => $existingHousing->original_city ?? '',
            'current_displacement_destination' => $existingHousing->current_displacement_destination ?? '',
            'current_address_details'          => $existingHousing->detailed_current_address ?? '',

            // البيانات المالية
            'financial_entity'        => $existingFinancial->official_receiving_entity ?? '',
            'account_holder_name'     => $existingFinancial->account_holder_name ?? '',
            'iban_or_account_number'  => $existingFinancial->bank_account_or_iban ?? '',
        ];

        return view('guardian.child-form', [
            'user' => $user,
            'prefill' => $prefill
        ]);
    }

    /**
     * صفحة تعديل طفل محدد
     */
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
        $d = fn($v) => $v ? substr((string) $v, 0, 10) : null;

        $prefill = [
            'child_first_name'       => $orphan->first_name,
            'child_full_name'        => $orphan->name,
            'child_rating'           => $orphan->rating ?? 1,
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

            'guardian_name'           => $g->name ?? null,
            'guardian_national_id'    => $g->national_id ?? null,
            'guardian_birth_date'     => $d($g->birth_date ?? null),
            'guardian_relationship'   => $g->kinship_relation ?? null,
            'guardian_marital_status' => $g->marital_status ?? null,
            'guardian_health_status'  => $g->health_status ?? null,
            'guardian_health_details' => $g->health_details ?? null,
            'family_income_source'    => $g->income_source ?? null,

            'father_name'         => $p->name ?? null,
            'father_national_id'  => $p->national_id ?? null,
            'father_death_date'   => $d($p->death_date ?? null),
            'father_death_reason' => $p->death_reason ?? null,
            'mother_alive'        => isset($p) ? ($p->is_mother_alive ? 'yes' : 'no') : 'yes',
            'mother_death_date'   => $d($p->mother_death_date ?? null),
            'mother_death_reason' => $p->mother_death_reason ?? null,

            'housing_type'                     => $h->current_housing_type ?? null,
            'housing_condition'                => $h->housing_condition ?? null,
            'housing_damage_details'           => $h->damage_description ?? null,
            'original_city'                    => $h->original_city ?? null,
            'current_displacement_destination' => $h->current_displacement_destination ?? null,
            'current_address_details'          => $h->detailed_current_address ?? null,

            'financial_entity'        => $f->official_receiving_entity ?? null,
            'account_holder_name'     => $f->account_holder_name ?? null,
            'iban_or_account_number'  => $f->bank_account_or_iban ?? null,
            'family_financial_rating' => isset($f) ? ($ratingMap[$f->family_financial_status] ?? null) : null,
        ];

        return view('guardian.child-form', ['editId' => $id, 'prefill' => $prefill, 'user' => $user]);
    }

    /**
     * تحديث بيانات طفل محدد
     */
    public function update(ChildRequest $request, string $id)
    {
        $orphan = orphans::findOrFail($id);
        if (!$orphan) {
            return redirect()->route('login');
        }

        DB::beginTransaction();
        try {
            // 1. تحديث بيانات اليتيم
            $orphan->first_name = $request->child_first_name;
            $orphan->name = $request->child_full_name;
            $orphan->rating = $request->input('child_rating');
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
            $orphan->rating = $orphan->is_double_orphan + $orphan->is_sole_breadwinner + $orphan->is_critically_needy + $orphan->is_war_injured + $orphan->has_chronic_disease;

            // 2. تحديث بيانات الوصي
            $guardian = Guardian::firstOrNew(['user_id' => Auth::id()]);
            $guardian->user_id = Auth::id();
            $guardian->name = $request->guardian_name;
            $guardian->national_id = $request->guardian_national_id;
            $guardian->birth_date = $request->guardian_birth_date;
            $guardian->kinship_relation = $request->guardian_relationship;
            $guardian->marital_status = $request->guardian_marital_status;
            $guardian->health_status = $request->guardian_health_status;
            $guardian->health_details = $request->guardian_health_details;
            $guardian->income_source = $request->family_income_source;

            if ($request->hasFile('guardian_id_photo')) {
                $gIdName = 'guardian_id_' . time() . '.' . $request->guardian_id_photo->extension();
                $request->guardian_id_photo->move(public_path('Uploads/guardians'), $gIdName);
                $guardian->guardian_id_image = $gIdName;
            } elseif (!$guardian->guardian_id_image) {
                $guardian->guardian_id_image = 'default.png';
            }

            if ($request->hasFile('guardian_legal_document')) {
                $gDocName = 'legal_doc_' . time() . '.' . $request->guardian_legal_document->extension();
                $request->guardian_legal_document->move(public_path('Uploads/guardians'), $gDocName);
                $guardian->legal_guardianship_document = $gDocName;
            } elseif (!$guardian->legal_guardianship_document) {
                $guardian->legal_guardianship_document = 'default.pdf';
            }
            $guardian->save();

            $orphan->guardian_id = $guardian->id;
            $orphan->save();

            // 3. تحديث بيانات الوالدين
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
            } elseif (!$parent->death_certificate) {
                $parent->death_certificate = 'default.pdf';
            }

            if ($request->hasFile('mother_death_certificate')) {
                $mDeath = 'mother_death_' . time() . '.' . $request->mother_death_certificate->extension();
                $request->mother_death_certificate->move(public_path('Uploads/parents'), $mDeath);
                $parent->mother_death_certificate = $mDeath;
            }
            $parent->save();

            // 4. تحديث بيانات السكن
            $housing = Housing::firstOrNew(['orphan_id' => $orphan->id]);
            $housing->current_housing_type = $request->housing_type;
            $housing->housing_condition = $request->housing_condition;
            $housing->damage_description = $request->housing_damage_details;
            $housing->original_city = $request->original_city;
            $housing->current_displacement_destination = $request->current_displacement_destination;
            $housing->detailed_current_address = $request->current_address_details;
            $housing->orphan_id = $orphan->id;
            $housing->save();

            // 5. تحديث البيانات المالية
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
                'user_id' => Auth::id(),
                'action'  => 'تعديل بيانات طفل',
                'details' => 'تم تحديث بيانات الطفل ' . $orphan->name,
            ]);

            return redirect()->route('children')->with('success', 'تم تحديث بيانات اليتيم وعائلته بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('update child failed: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->withErrors(['error' => 'حدث خطأ أثناء التحديث: ' . $e->getMessage()]);
        }
    }

    /**
     * حذف طفل محدد
     */
    public function destroy(string $id)
    {
        $orphan = orphans::findOrFail($id);
        if (!$orphan) {
            return redirect()->route('login');
        }
        $orphan->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'حذف طفل',
            'details' => 'تم حذف الطفل ' . $orphan->name,
        ]);

        return redirect()->route('children')->with('success', 'تم حذف اليتيم وكافة بياناته المرتبطة بنجاح.');
    }

    /**
     * إضافة طفل جديد وربطه بالوصي الحالي
     */
    public function new_child_form(ChildRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        DB::beginTransaction();

        try {
            // 1. حفظ / تحديث بيانات الوصي للحصول على guardian_id
            $guardian = Guardian::firstOrNew(['user_id' => Auth::id()]);
            $guardian->user_id = Auth::id();
            $guardian->name = $request->guardian_name;
            $guardian->national_id = $request->guardian_national_id;
            $guardian->birth_date = $request->guardian_birth_date;
            $guardian->kinship_relation = $request->guardian_relationship;
            $guardian->marital_status = $request->guardian_marital_status;
            $guardian->health_status = $request->guardian_health_status;
            $guardian->health_details = $request->guardian_health_details;
            $guardian->income_source = $request->family_income_source;

            if ($request->hasFile('guardian_id_photo')) {
                $gIdName = 'guardian_id_' . time() . '.' . $request->guardian_id_photo->extension();
                $request->guardian_id_photo->move(public_path('Uploads/guardians'), $gIdName);
                $guardian->guardian_id_image = $gIdName;
            } elseif (!$guardian->guardian_id_image) {
                $guardian->guardian_id_image = 'default.png';
            }

            if ($request->hasFile('guardian_legal_document')) {
                $gDocName = 'legal_doc_' . time() . '.' . $request->guardian_legal_document->extension();
                $request->guardian_legal_document->move(public_path('Uploads/guardians'), $gDocName);
                $guardian->legal_guardianship_document = $gDocName;
            } elseif (!$guardian->legal_guardianship_document) {
                $guardian->legal_guardianship_document = 'default.pdf';
            }

            $guardian->save();

            // 2. حفظ بيانات الطفل الجديد وربطه بالـ guardian_id
            $orphan = new orphans();
            $orphan->guardian_id = $guardian->id;
            $orphan->first_name = $request->child_first_name;
            $orphan->name = $request->child_full_name;
            $orphan->national_id = $request->child_national_id;
            $orphan->birth_date = $request->child_birth_date;
            $orphan->age = $request->child_age;

            $genderMap = ['0' => 'ذكر', '1' => 'أنثى', 'ذكر' => 'ذكر', 'أنثى' => 'أنثى'];
            $orphan->gender = $genderMap[$request->child_gender] ?? $request->child_gender;

            $orphan->education_level = $request->child_education_status;
            $orphan->orphan_location_status = $request->child_presence_status;

            $orphan->is_double_orphan = $request->has('badge_both_parents') ? 1 : 0;
            $orphan->is_sole_breadwinner = $request->has('badge_lone_survivor') ? 1 : 0;
            $orphan->is_critically_needy = $request->has('badge_extreme_need') ? 1 : 0;
            $orphan->is_war_injured = $request->has('badge_injured') ? 1 : 0;
            $orphan->has_chronic_disease = $request->has('badge_chronic_disease') ? 1 : 0;

            $orphan->rating = $orphan->is_double_orphan + $orphan->is_sole_breadwinner + $orphan->is_critically_needy + $orphan->is_war_injured + $orphan->has_chronic_disease;

            $orphan->health_status = $request->child_health_status;
            $orphan->health_description = $request->child_medical_needs;
            $orphan->story = $request->child_story;
            $orphan->data_acknowledgement = $request->has('legal_affirmation') ? 1 : 0;

            $orphan->country = $request->input('country', 'فلسطين');
            $orphan->city = $request->original_city ?? 'Gaza';
            $orphan->status = 'بانتظار القبول';

            if ($request->hasFile('child_photo')) {
                $fileName = 'orphan_' . time() . '_' . $request->child_first_name . '.' . $request->child_photo->extension();
                $request->child_photo->move(public_path('Uploads/orphans'), $fileName);
                $orphan->personal_photo_path = $fileName;
            } else {
                $orphan->personal_photo_path = 'default.png';
            }

            if ($request->hasFile('child_birth_certificate')) {
                $certName = 'birth_' . time() . '.' . $request->child_birth_certificate->extension();
                $request->child_birth_certificate->move(public_path('Uploads/certificates'), $certName);
                $orphan->birth_certificate_path = $certName;
            } else {
                $orphan->birth_certificate_path = 'default_cert.png';
            }

            $orphan->save();

            // 3. حفظ بيانات الوالدين
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

            // 4. حفظ بيانات السكن والنزوح
            $housing = new Housing();
            $housing->orphan_id = $orphan->id;
            $housing->current_housing_type = $request->housing_type;
            $housing->housing_condition = $request->housing_condition;
            $housing->damage_description = $request->housing_damage_details;
            $housing->original_city = $request->original_city;
            $housing->current_displacement_destination = $request->current_displacement_destination;
            $housing->detailed_current_address = $request->current_address_details;
            $housing->save();

            // 5. حفظ البيانات المالية
            $financial = new financial_data();
            $financial->orphan_id = $orphan->id;
            $financial->official_receiving_entity = $request->financial_entity;
            $financial->account_holder_name = $request->account_holder_name;
            $financial->bank_account_or_iban = $request->iban_or_account_number;

            $statusMap = ['حالة ضعيفة' => 'weak', 'حالة متوسطة' => 'medium', 'حالة جيدة' => 'good'];
            $financial->family_financial_status = $statusMap[$request->family_financial_rating] ?? 'weak';
            $financial->save();

            DB::commit();

            AuditLog::create([
                'user_id' => Auth::id(),
                'action'  => 'إضافة طفل جديد',
                'details' => 'تم إضافة طفل جديد باسم: ' . $orphan->name,
            ]);

            return redirect()->route('children')->with('success', 'تم إضافة الطفل بنجاح وتوزيع البيانات على الجداول.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('new_child_form failed: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->withErrors(['error' => 'حدث خطأ أثناء الحفظ: ' . $e->getMessage()]);
        }
    }

    /**
     * صفحة رفع المستندات لكل أطفال الوصي
     */
    public function upload_docs()
    {
        $user = Auth::user();

        $guardian = Guardian::where('user_id', $user->id)->first();

        if (!$guardian) {
            return view('guardian.upload-docs', [
                'orphan' => collect(),
                'user'   => $user
            ]);
        }

        // جلب جميع أطفال الوصي لإتاحة اختيار الطفل المراد رفع المستند له من المنسدلة
        $orphan = orphans::where('guardian_id', $guardian->id)->get();

        return view('guardian.upload-docs', [
            'orphan' => $orphan,
            'user'   => $user
        ]);
    }

    /**
     * حفظ المستند المرفوع بملف Request مستقل
     */
    public function upload_docs_store(UploadDocumentRequest $request)
    {
        $document = new documents;
        $document->title = $request->title;
        $document->doc_type = $request->doc_type;
        $document->orphan_id = $request->orphan_id;
        $document->date = now()->format('Y-m-d');

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $d = 'document_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $document->file_path = 'Uploads/document/' . $d;
            $file->move(public_path('Uploads/document'), $d);
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'اضافة مستندات',
            'details' => 'تم اضافة مستند من نوع ' . $request->doc_type . ' لصالح الطفل ' . $request->orphan_id,
        ]);

        $document->save();

        return redirect()->route('children')->with('success', 'تم رفع المستند بنجاح وهو قيد المراجعة الآن.');
    }

    /**
     * عرض جميع الحوالات والمدفوعات لجميع أطفال هذا الوصي
     */
    public function received_payments()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $guardian = Guardian::where('user_id', $user->id)->first();

        if (!$guardian) {
            return view('guardian.received-payments', [
                'user'          => $user,
                'payments'      => collect(),
                'totalReceived' => 0,
                'paymentsCount' => 0
            ]);
        }

        // جلب معرفات كل الأطفال التابعين للوصي
        $orphanIds = orphans::where('guardian_id', $guardian->id)->pluck('id');

        if ($orphanIds->isEmpty()) {
            return view('guardian.received-payments', [
                'user'          => $user,
                'payments'      => collect(),
                'totalReceived' => 0,
                'paymentsCount' => 0
            ]);
        }

        $query = Sponsorship::whereIn('orphan_id', $orphanIds);

        $payments = (clone $query)
            ->with(['orphan'])
            ->latest()
            ->paginate(10);

        $paymentsCount = $payments->total();

        $totalReceived = (clone $query)
            ->where('payment_status', 'paid')
            ->sum('amount_paid');

        return view('guardian.received-payments', compact('user', 'payments', 'totalReceived', 'paymentsCount'));
    }

    /**
     * الإشعارات
     */
    public function notifications()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->paginate(10);

        return view('guardian.notifications', compact('user', 'notifications'));
    }

    public function markAllRead()
    {
        try {
            $user = Auth::user();
            $user->unreadNotifications->markAsRead();

            return redirect()->back()->with('success', 'تم تعليم جميع الإشعارات كمقروءة بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث حالة الإشعارات.');
        }
    }

    /**
     * الصفحة الشخصية للوصي
     */
    public function profile()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $guardian = $user->guardian ?? Guardian::where('user_id', $user->id)->first();
        $housing  = null;

        if ($guardian) {
            $orphanIds = orphans::where('guardian_id', $guardian->id)->pluck('id');

            $housing = Housing::where('guardian_id', $guardian->id)
                ->when($orphanIds->isNotEmpty(), function ($query) use ($orphanIds) {
                    $query->orWhereIn('orphan_id', $orphanIds);
                })
                ->latest()
                ->first();
        }

        return view('guardian.profile', [
            'user'     => $user,
            'guardian' => $guardian,
            'housing'  => $housing
        ]);
    }

    public function updateProfileFields(UpdateGuardianProfileRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // 1. تحديث بيانات المستخدم
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

        // 2. جلب الوصي
        $guardian = $user->guardian ?? Guardian::where('user_id', $user->id)->first();

        if ($guardian) {
            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $filename = 'guardian_avatar_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('Uploads/guardians'), $filename);
                $guardian->image = $filename;
            }

            if ($request->filled('name')) {
                $guardian->name = $request->name;
            }

            if ($request->has('health_status')) {
                $guardian->health_status = $request->health_status;
            }

            $guardian->save();

            // 3. تحديث السكن الحقيقي المرتبط بالوصي أو بأي من أطفاله
            if ($request->has('current_displacement_destination')) {
                $orphanIds = orphans::where('guardian_id', $guardian->id)->pluck('id');

                // جلب نفس السجل الذي يتم استعراضه في صفحة الـ profile بالضبط
                $housing = Housing::where('guardian_id', $guardian->id)
                    ->when($orphanIds->isNotEmpty(), function ($query) use ($orphanIds) {
                        $query->orWhereIn('orphan_id', $orphanIds);
                    })
                    ->latest()
                    ->first();

                if ($housing) {
                    // تحديث السجل الموجود فعلياً
                    $housing->current_displacement_destination = $request->current_displacement_destination;
                    if (!$housing->guardian_id) {
                        $housing->guardian_id = $guardian->id;
                    }
                    $housing->save();
                } else {
                    // إنشاء سجل جديد في حال عدم وجود أي سكن مسبق
                    Housing::create([
                        'guardian_id'                      => $guardian->id,
                        'current_displacement_destination' => $request->current_displacement_destination,
                        'current_housing_type'             => 'غير محدد',
                        'housing_condition'                => 'غير محدد',
                        'original_city'                    => 'غير محدد',
                        'detailed_current_address'         => $request->detailed_current_address ?? 'غير محدد',
                    ]);
                }

                AuditLog::create([
                    'user_id' => Auth::id(),
                    'action'  => 'تعديل بيانات وصي',
                    'details' => 'قام الوصي بتحديث بياناته الشخصية ووجهة النزوح',
                ]);
            }
        }

        return redirect()->route('profile')->with('success', 'تم تحديث البيانات والصورة بنجاح!');
    }

    /**
     * تغيير كلمة المرور عبر Form Request مخصص
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'تم تغيير كلمة المرور بنجاح!');
    }
}
