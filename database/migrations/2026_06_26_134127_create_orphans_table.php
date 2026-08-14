<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orphans', function (Blueprint $table) {
            $table->id();
            $table->string('first_name'); // الاسم_الاول
            $table->string('name'); // الاسم_الكامل
            $table->string('national_id', 9)->unique(); // رقم الهوية
            $table->date('birth_date'); // تاريخ_الميلاد
            $table->integer('age'); // العمر
            $table->string('gender'); // الجنس
            $table->string('education_level'); // المستوى التعليمي
            $table->string('orphan_location_status'); // مكان التواجد

            $table->boolean('is_double_orphan')->default(false);          // يتيم الأبوين
            $table->boolean('is_sole_breadwinner')->default(false);       // ناجي وحيد
            $table->boolean('is_critically_needy')->default(false);       // حالة معيشية أشد حاجة
            $table->boolean('is_war_injured')->default(false);            // مصاب حرب / جريح
            $table->boolean('has_chronic_disease')->default(false);       // يعاني من مرض مزمن

            $table->string('health_status'); // الحالة الصحية
            $table->text('health_description')->nullable(); // وصف الحالة الصحية
            $table->text('story')->nullable(); // القصة (اختيارية في الفورم)
            $table->string('birth_certificate_path'); // صورة شهادة ميلاد الطفل
            $table->string('personal_photo_path'); // صورة اليتيم الشخصية الرسمية

            $table->boolean('data_acknowledgement')->default(false);      // أقر بموثوقية كافة البيانات والمستندات...

            $table->string('country'); // الدولة
            $table->string('city'); // المدينة
            $table->enum('status', ['مرفوض', 'مكفول', 'بانتظار الكفالة', 'بانتظار القبول'])->default('بانتظار القبول'); //  حالة الكفالة (بانتظار الكفيل)
            $table->string('urgency_level')->nullable(); // مستوى الحاجة

            $table->decimal('required_amount', 8, 2)->default(50.00); // المبلغ المطلوب للكفالة

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orphans');
    }
};
