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
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('users')->whereIn('id', DB::table('guardians')->pluck('user_id'))->delete();

        documents::truncate();
        financial_data::truncate();
        Housing::truncate();
        guardian::truncate();
        Parents::truncate();
        orphans::truncate();

        Schema::enableForeignKeyConstraints();

        orphans::factory()
            ->count(20)
            ->create()
            ->each(function ($orphan) {

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
