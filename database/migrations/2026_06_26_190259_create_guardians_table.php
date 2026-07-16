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
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // الاسم
            $table->string('national_id', 9)->unique(); // رقم الهوية
            $table->date('birth_date'); // تاريخ الميلاد
            $table->string('kinship_relation'); // صلة القرابة باليتيم
            $table->string('marital_status'); // الحالة الاجتماعية
            $table->string('health_status'); // الحالة الصحية للوصي
            $table->text('health_details')->nullable(); // تفاصيل الحالة الصحية والطبية للوصي
            $table->string('income_source')->nullable(); // مصدر الدخل (اختياري في الفورم)

            $table->string('guardian_id_image'); // صورة هوية الوصي الشخصية
            $table->string('legal_guardianship_document'); // صك الوصاية القانونية الشرعي

            // المفتاح الأجنبي يشير إلى اليتيم (اليتيم هو الكيان الأب). الاسم صُحِّح من guardian_id إلى orphan_id.
            $table->foreignId('orphan_id')->references('id')->on('orphans')->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardians');
    }
};
