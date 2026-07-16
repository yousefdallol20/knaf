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
        Schema::create('housings', function (Blueprint $table) {
            $table->id();
            $table->string('current_housing_type'); // نوع السكن
            $table->string('housing_condition'); // حالة وصلاحية السكن
            $table->text('damage_description')->nullable(); //وصف أضرار وتصدعات المسكن بالتفصيل
            $table->string('original_city');//المدينة قبل الحرب
            $table->string('current_displacement_destination'); // وجهة النزوح الحالية بالكامل
            $table->text('detailed_current_address'); // تموضع السكن والعنوان التفصيلي الحالي
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
        Schema::dropIfExists('housings');
    }
};
