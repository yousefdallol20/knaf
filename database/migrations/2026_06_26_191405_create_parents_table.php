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
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // الاسم
            $table->string('national_id', 9)->nullable(); // رقم هوية الأب (اختياري في الفورم)
            $table->date('death_date')->nullable(); // تاريخ الوفاة (اختياري في الفورم)
            $table->string('death_reason')->nullable(); // سبب الوفاة (اختياري في الفورم)
            $table->string('death_certificate'); // شهادة الوفاة (يضع الكنترولر قيمة افتراضية)

            $table->boolean('is_mother_alive')->default(true); // هل الأم لا تزال على قيد الحياة
            $table->date('mother_death_date')->nullable(); // تاريخ وفاة
            $table->string('mother_death_reason')->nullable(); // سبب وفاة
            $table->string('mother_death_certificate')->nullable(); // شهادة وفاة

            // المفتاح الأجنبي يشير إلى اليتيم. الاسم صُحِّح من Parent_id إلى orphan_id.
            $table->foreignId('orphan_id')->references('id')->on('orphans')->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};
