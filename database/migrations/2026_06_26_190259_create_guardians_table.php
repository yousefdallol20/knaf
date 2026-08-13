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

            // 2️⃣ جعل الحقول قابلة للـ NULL مؤقتاً لحين إكمال بيانات الملف الشخصي
            $table->string('national_id', 9)->nullable(); // رقم الهوية
            $table->date('birth_date')->nullable(); // تاريخ الميلاد
            $table->string('kinship_relation')->nullable(); // صلة القرابة باليتيم
            $table->string('marital_status')->nullable(); // الحالة الاجتماعية
            $table->string('health_status')->nullable(); // الحالة الصحية للوصي
            $table->text('health_details')->nullable(); // تفاصيل الحالة الصحية والطبية للوصي
            $table->string('income_source')->nullable(); // مصدر الدخل (اختياري)

            // 3️⃣ وضع قيم افتراضية للمستندات والأسناد
            $table->string('guardian_id_image')->nullable()->default('default.jpg'); // صورة هوية الوصي الشخصية
            $table->string('legal_guardianship_document')->nullable()->default('default.pdf'); // صك الوصاية القانونية الشرعي

            // 4️⃣ جعل orphan_id قابل للـ NULL لأن الوصي ينشئ حسابه قبل إضافة الأيتام
            $table->foreignId('orphan_id')->nullable()->references('id')->on('orphans')->onUpdate('cascade')->onDelete('cascade');
            // 1️⃣ إضافة المفتاح الأجنبي لربط الوصي بحساب المستخدم
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');

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
