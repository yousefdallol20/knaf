<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChildRequest;
use App\Models\documents;
use App\Models\financial_data;
use App\Models\guardian;
use App\Models\Housing;
use App\Models\orphans;
use App\Models\Parents;
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
    public function dashboard()
    {
        // $guardian = guardian::all();
        $user = Auth::user();

        // 2. جلب الوصي المرتبط بهذا المستخدم
        $guardian = guardian::where('user_id', $user->id)->first();
        if (!$guardian) {
            return redirect()->route('login');
        }
        // 3. جلب الأطفال التابعين لهذا الوصي فقط بناءً على هيكلية جداولك الحالية
        $orphan = orphans::where('id', $guardian->orphan_id)->get();

        // 4. حساب الإحصائيات الخاصة بهذا الوصي
        $childrenCount = orphans::where('id', $guardian->orphan_id)->count();

        $activeSponsorships = orphans::where('id', $guardian->orphan_id)
            ->where('status', 'نشط مكفول')
            ->count();

        $hasDocs = documents::where('orphan_id', $guardian->orphan_id)->exists();
        $requiredDocsCount = $hasDocs ? 0 : 1;

        // 5. تمرير المتغيرات المحسوبة ديناميكياً لملف الـ View
        return view('guardian.dashboard', [
            'orphan'             => $orphan,
            'childrenCount'      => $childrenCount,
            'activeSponsorships' => $activeSponsorships,
            'requiredDocsCount'  => $requiredDocsCount,
            'user'               => $user
        ]);
    }
    /**
     *  guardian folder .
     *  children page .
     */
    public function children()
    {
        $user = Auth::user();

        // 1. جلب سجل الوصي الحالي المسجل دخوله
        $guardian = guardian::where('user_id', $user->id)->first();

        // في حال كان حساب الوصي جديداً ولم يربط بطفل بعد
        if (!$guardian) {
            return redirect()->route('login');
        }

        // 2. جلب الطفل التابع لهذا الوصي فقط بدلاً من orphans::all()
        $orphan = orphans::where('id', $guardian->orphan_id)->get();

        // 3. جلب الوثائق الخاصة بهذا الطفل فقط بدلاً من documents::all() لتسريع الأداء
        $document = documents::where('orphan_id', $guardian->orphan_id)->get();

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
        return view('guardian.child-form', ['user' => $user]);
    }

    // عرض نفس فورم الإنشاء لكن معبأ ببيانات اليتيم وعائلته (وضع التعديل)
    public function edit(string $id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        $orphan = orphans::with(['guardian', 'parents', 'housing', 'financial'])->findOrFail($id);
        $g = $orphan->guardian;
        $p = $orphan->parents;
        $h = $orphan->housing;
        $f = $orphan->financial;

        $genderMap = ['ذكر', 'أنثى'];
        $ratingMap = ['حالة ضعيفة',  'حالة متوسطة', 'حالة جيدة'];
        $d = fn($v) => $v ? substr((string) $v, 0, 10) : null; // تنسيق التاريخ لحقل input[type=date]

        // القيم المعبأة مسبقاً، مُحوّلة إلى أسماء حقول الفورم وتُمرَّر كمتغيّر صريح للـ view.
        // حقول الـ checkbox تُمثَّل بـ '1' عند التفعيل و '' عند عدمه لتتوافق مع old() في الفورم.
        $prefill = [
            // اليتيم
            'child_first_name'       => $orphan->first_name,
            'child_full_name'        => $orphan->name,
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
            $guardian = guardian::firstOrNew(['orphan_id' => $orphan->id]);
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
            // 1. حفظ اليتيم أولاً (لأن الجداول الأخرى تعتمد على الـ ID الخاص به)
            $orphan = new orphans; // أو orphans حسب اسم الموديل عندك
            $orphan->first_name = $request->child_first_name;
            $orphan->name = $request->child_full_name;
            $orphan->national_id = $request->child_national_id;
            $orphan->birth_date = $request->child_birth_date;
            $orphan->age = $request->child_age;

            $genderMap = ['ذكر', 'أنثى'];
            $orphan->gender = $genderMap[$request->child_gender] ?? $request->child_gender;

            $orphan->education_level = $request->child_education_status;
            $orphan->orphan_location_status = $request->child_presence_status;

            // حقول الـ Checkbox (تحويلها إلى Boolean)
            $orphan->is_double_orphan = $request->has('badge_both_parents') ? 1 : 0;
            $orphan->is_sole_breadwinner = $request->has('badge_lone_survivor') ? 1 : 0;
            $orphan->is_critically_needy = $request->has('badge_extreme_need') ? 1 : 0;
            $orphan->is_war_injured = $request->has('badge_injured') ? 1 : 0;
            $orphan->has_chronic_disease = $request->has('badge_chronic_disease') ? 1 : 0;

            $orphan->health_status = $request->child_health_status;
            $orphan->health_description = $request->child_medical_needs;
            $orphan->story = $request->child_story;
            $orphan->data_acknowledgement = $request->has('legal_affirmation') ? 1 : 0;

            // حقول إضافية بالـ migration لليتيم (أعطها قيماً افتراضية لتجنب خطأ الـ NOT NULL)
            $orphan->country = 'Palestine';
            $orphan->city = $request->original_city ?? 'Gaza';
            $orphan->status = 'بانتظار الكفالة';

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

            $orphan->save(); // تم الحفظ وتوليد الـ ID لليتيم

            // 2. حفظ بيانات الوصي (Guardian)
            $guardian = new Guardian;
            $guardian->name = $request->guardian_name;
            $guardian->national_id = $request->guardian_national_id;
            $guardian->birth_date = $request->guardian_birth_date;
            $guardian->kinship_relation = $request->guardian_relationship;
            $guardian->marital_status = $request->guardian_marital_status;
            $guardian->health_status = $request->guardian_health_status;
            $guardian->health_details = $request->guardian_health_details;
            $guardian->income_source = $request->family_income_source;
            $guardian->orphan_id = $orphan->id; // ربط المفتاح الأجنبي باليتيم
            $guardian->user_id = Auth::id();
            // صورة هوية الوصي (اختيارية) — فحص الوجود وقيمة افتراضية لأن العمود NOT NULL
            if ($request->hasFile('guardian_id_photo')) {
                $gIdName = 'guardian_id_' . time() . '.' . $request->guardian_id_photo->extension();
                $request->guardian_id_photo->move(public_path('Uploads/guardians'), $gIdName);
                $guardian->guardian_id_image = $gIdName;
            } else {
                $guardian->guardian_id_image = 'default.png';
            }

            // صك الوصاية القانوني (اختياري) — فحص الوجود وقيمة افتراضية
            if ($request->hasFile('guardian_legal_document')) {
                $gDocName = 'legal_doc_' . time() . '.' . $request->guardian_legal_document->extension();
                $request->guardian_legal_document->move(public_path('Uploads/guardians'), $gDocName);
                $guardian->legal_guardianship_document = $gDocName;
            } else {
                $guardian->legal_guardianship_document = 'default.pdf';
            }

            if ($request->hasFile('guardian')) {
                $fileName = 'guardian_' . time() . '_' . $request->guardian_first_name . '.' . $request->guardian_photo->extension();
                $request->guardian_photo->move(public_path('Uploads/guardian'), $fileName);
                $orphan->image = $fileName;
                $orphan->personal_photo_path = $fileName;
            } else {
                $orphan->image = 'default.png';
                $orphan->personal_photo_path = 'default.png';
            }

            $guardian->save();


            // 3. حفظ بيانات الوالدين (Parents)
            $parent = new Parents;
            $parent->name = $request->father_name;
            $parent->national_id = $request->father_national_id;
            $parent->death_date = $request->father_death_date;
            $parent->death_reason = $request->father_death_reason;
            $parent->is_mother_alive = ($request->mother_alive == 'yes') ? 1 : 0;
            $parent->mother_death_date = $request->mother_death_date;
            $parent->mother_death_reason = $request->mother_death_reason;
            $parent->orphan_id = $orphan->id; // ربط المفتاح الأجنبي باليتيم

            // رفع شهادات الوفاة للأب والأم
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
            $housing = new Housing;
            $housing->current_housing_type = $request->housing_type;
            $housing->housing_condition = $request->housing_condition;
            $housing->damage_description = $request->housing_damage_details;
            $housing->original_city = $request->original_city;
            $housing->current_displacement_destination = $request->current_displacement_destination;
            $housing->detailed_current_address = $request->current_address_details;
            $housing->orphan_id = $orphan->id;
            $housing->save();


            // 5. حفظ البيانات المالية (Financial Data)
            $financial = new financial_data; // أو financial_data حسب اسم الموديل عندك
            $financial->official_receiving_entity = $request->financial_entity;
            $financial->account_holder_name = $request->account_holder_name;
            $financial->bank_account_or_iban = $request->iban_or_account_number;

            // تحويل الحالة المالية المكتوبة بالعربي إلى القيم المقابلة في الـ enum (weak, medium, good)
            $statusMap = ['حالة ضعيفة' => 'weak', 'حالة متوسطة' => 'medium', 'حالة جيدة' => 'good'];
            $financial->family_financial_status = $statusMap[$request->family_financial_rating] ?? 'weak';
            $financial->orphan_id = $orphan->id;
            $financial->save();

            // تأكيد الحفظ الفعلي بقاعدة البيانات لجميع الجداول
            DB::commit();

            return redirect()->route('children', ['user' => $user])->with('success', 'تم إضافة الطفل بنجاح وتوزيع البيانات على الجداول.');
        } catch (\Exception $e) {
            // في حال حدوث أي خطأ إلغاء كافة العمليات السابقة لمنع تضارب الجداول
            DB::rollBack();

            // تسجيل الخطأ الفعلي في اللوج لتتبّعه حتى لو لم يُعرض كامله للمستخدم
            Log::error('new_child_form failed: ' . $e->getMessage(), ['exception' => $e]);

            // العودة لنفس الفورم مع الاحتفاظ بالإدخالات وعرض الرسالة تحت مفتاح "error" المطابق للـ blade
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

        // 1. جلب سجل الوصي المرتبط بالمستخدم الحالي
        $guardian = guardian::where('user_id', $user->id)->first();

        // 2. في حال كان الحساب جديداً ولم يُربط بطفل بعد لتجنب الأخطاء
        if (!$guardian) {
            return redirect()->route('login');
        }

        // 3. جلب الأطفال التابعين لهذا الوصي فقط بناءً على هيكلية جدولك
        $orphan = orphans::where('id', $guardian->orphan_id)->get();

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
        return view('guardian.received-payments', ['user' => $user]);
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

        // 1. التحقق من المدخلات
        $request->validate([
            'name'                             => 'required|string|max:255',
            'phone'                            => 'required|string|unique:users,phone,' . $user->id,
            'current_displacement_destination' => 'required|string|max:255',
            'health_status'                    => 'required|string|max:500',
            'profile_photo'                    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. تحديث جدول الـ users
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->save();

        // 3. تحديث بيانات جدول الـ guardians المرتبط بالمستخدم الحالي
        if ($user->guardian) {

            // معالجة ورفع الصورة الشخصية الجديدة في حال تم اختيارها
            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $filename = 'guardian_avatar_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // نقل الصورة للمجلد الموحد public/Uploads/guardians
                $file->move(public_path('Uploads/guardians'), $filename);

                // حفظ اسم الصورة الجديد في حقل image المخصص داخل جدول guardians
                $user->guardian->image = $filename;
            }

            // تحديث باقي الحقول التابعة للـ guardian
            $user->guardian->name = $request->name;
            $user->guardian->health_status = $request->health_status;
            $user->guardian->save();

            // 4. تحديث أو إنشاء صف السكن (Housing)
            Housing::updateOrCreate(
                ['guardian_id' => $user->guardian->id],
                [
                    'current_displacement_destination' => $request->current_displacement_destination,
                    'current_housing_type'             => $user->guardian->housing->current_housing_type ?? 'غير محدد',
                    'housing_condition'                => $user->guardian->housing->housing_condition ?? 'غير محدد',
                    'orphan_id'                        => $user->guardian->orphan_id
                ]
            );
        }

        return redirect()->back()->with('success', 'تم تحديث البيانات الشخصية بنجاح!');
    }

    /**
     * دالة تغيير كلمة المرور (الفورم الثاني)
     */
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
            'password'         => 'required|string|min:6|confirmed', // confirmed تطلب تلقائياً حقل باسم password_confirmation
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
