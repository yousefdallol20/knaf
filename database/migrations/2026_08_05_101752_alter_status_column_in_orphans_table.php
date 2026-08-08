<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orphans', function (Blueprint $table) {
            // تحويل العمود إلى string لتفادي قيود ENUM أو الحجم الصغير
            $table->string('status', 50)->change();
        });
    }

    public function down(): void
    {
        //
    }
};
