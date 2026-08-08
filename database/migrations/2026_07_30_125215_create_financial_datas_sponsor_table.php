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
        Schema::create('financial_datas_sponsor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->onDelete('cascade');
            $table->decimal('total', 10, 2)->default(0.00); // العمود المطلوب للمايجريشن لحساب إجمالي المدفوعات
            $table->decimal('monthly_amount', 10, 2)->default(0.00);
            $table->string('payment_method')->nullable();
            $table->string('status')->default('paid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_datas_sponsor');
    }
};
