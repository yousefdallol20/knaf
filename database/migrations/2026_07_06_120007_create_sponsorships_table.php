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
        Schema::create('sponsorships', function (Blueprint $table) {
            $table->id();

            // 1. العلاقات الأساسية
            $table->foreignId('orphan_id')->references('id')->on('orphans')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('sponsor_id')->references('id')->on('sponsors')->onUpdate('cascade')->onDelete('cascade');

            // 2. تفاصيل مبالغ وتواريخ الكفالة
            $table->decimal('amount_paid', 10, 2); // المبلغ الإجمالي المحصل (مثال: 350.00)
            $table->date('start_date');            // تاريخ بدء الكفالة
            $table->date('last_batch')->nullable(); // تاريخ آخر دفعة تم التحقق منها

            // 3. طريقة وحالة الدفع المشتركة
            $table->enum('payment_method', ['card', 'bank_transfer']);
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');

            // 4. حقول الدفع الإلكتروني (فيزا / مدى) -> صورة image_d1b021.png
            // *تنبيه: لا نخزن بيانات الكرت الحساسة هنا*
            $table->string('transaction_id')->nullable(); // الرقم المرجعي للعملية القادم من بوابة الدفع الإلكترونية

            // 5. حقول التحويل المصرفي اليدوي -> صورة image_d1b076.png
            $table->string('bank_reference_number')->nullable(); // رقم مرجع التحويل الموجود في تطبيق بنك الكافل
            $table->string('bank_receipt_file')->nullable();     // مسار ملف/صورة إشعار تحويل البنك المرفقة

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsorships');
    }
};
