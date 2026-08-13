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
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();

            // 1️⃣ إضافة المفتاح الأجنبي لربط الكافل بحساب المستخدم
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');

            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('image')->nullable();

            // 2️⃣ إعطاء قيم افتراضية للحقول غير الموجودة في نموذج التسجيل
            $table->string('country')->nullable()->default('-');
            $table->string('city')->nullable()->default('-');
            $table->enum('status', ['active', 'inactive'])->default('active')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
};
