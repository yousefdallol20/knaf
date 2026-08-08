<?php

namespace Database\Seeders;

use App\Models\documents;
use App\Models\orphans;
use App\Models\Parents;
use App\Models\guardian;
use App\Models\Housing;
use App\Models\financial_data;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. تعطيل القيود مؤقتاً لتنظيف جداول الأيتام فقط بدون مسح قاعدة البيانات كاملة
        Schema::disableForeignKeyConstraints();

        // حذف المستخدمين المرتبطين بالأوصياء فقط (عشان ما نحذف حساب الأدمن أو أي مستخدم آخر تعبان عليه)
        DB::table('users')->whereIn('id', DB::table('guardians')->pluck('user_id'))->delete();

        // تفريغ جداول الأيتام والبيانات التابعة لها بالترتيب
        documents::truncate();
        financial_data::truncate();
        Housing::truncate();
        guardian::truncate();
        Parents::truncate();
        orphans::truncate();

        // إعادة تفعيل القيود
        Schema::enableForeignKeyConstraints();

        // 2. توليد 20 طفل فريش وجداد بالكامل
        orphans::factory()
            ->count(20)
            ->create()
            ->each(function ($orphan) {

                // 3. توليد البيانات الفرعية وربطها بالـ orphan_id للطفل الحالي
                Parents::factory()->create([
                    'orphan_id' => $orphan->id
                ]);

                guardian::factory()->create([
                    'orphan_id' => $orphan->id
                ]);

                Housing::factory()->create([
                    'orphan_id' => $orphan->id
                ]);

                financial_data::factory()->create([
                    'orphan_id' => $orphan->id
                ]);

                // 4. توليد المستندات الإضافية (من 1 إلى 3 لكل طفل)
                documents::factory()
                    ->count(rand(1, 3))
                    ->create([
                        'orphan_id' => $orphan->id
                    ]);
            });

        $this->call([
            AdminSeeder::class,
            SponsorSeeder::class,
        ]);
    }
}
