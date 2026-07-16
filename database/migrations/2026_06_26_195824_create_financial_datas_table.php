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
        Schema::create('financial_datas', function (Blueprint $table) {
            $table->id();
            $table->string('official_receiving_entity'); // جهة الاستلام المالي
            $table->string('account_holder_name'); // اسم صاحب الحساب
            $table->string('bank_account_or_iban'); // رقم الحساب
            $table->enum('family_financial_status', ['weak', 'medium', 'good']); // الحالة المالية
            // المفتاح الأجنبي لليتيم (كان مفقوداً والكنترولر يحاول كتابته)
            $table->foreignId('orphan_id')->references('id')->on('orphans')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_datas');
    }
};
