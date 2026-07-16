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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            // ربط التقرير بجدول الأيتام (Foreign Key)
            // في حال حُذف الطفل من النظام، تُحذف وثائقه تلقائياً لمنع تراكم الملفات المهملة
            $table->foreignId('orphan_id')->constrained('orphans')->onDelete('cascade');

            // نوع المستند (شهادة دراسية، كشف طبي، إلخ)
            $table->string('doc_type');

            // عنوان التتبع أو التوصيف المكتوب من قبل الوصي
            $table->string('title');

            $table->date("date");

            // مسار حفظ الملف المرفوع (PDF أو صورة) على السيرفر
            $table->string('file_path');

            // حالة التقرير (بانتظار المراجعة، مقبول، مرفوض)
            $table->enum('status', ['بانتظار المراجعة', 'مقبول', 'مرفوض'])->default('بانتظار المراجعة');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
