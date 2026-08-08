<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orphans', function (Blueprint $table) {
            // إضافة عمود تقييم الطفل (من 1 إلى 5 نجوم)
            $table->unsignedTinyInteger('rating')->default(1)->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('orphans', function (Blueprint $table) {
            $table->dropColumn('rating');
        });
    }
};
