<?php

namespace Database\Factories;

use App\Models\documents;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    protected $model = documents::class;

    public function definition(): array
    {
        return [
            'doc_type' => $this->faker->randomElement(['شهادة دراسية', 'تقرير طبي', 'إثبات الفقدان']),
            'title' => $this->faker->randomElement(['كشف درجات الفصل الأول', 'تقرير طبي معتمد', 'وثيقة رسمية']),
            'date' => $this->faker->date(),
            'file_path' => 'documents/doc_' . $this->faker->numberBetween(1000, 9999) . '.pdf',

            // حل قيد الـ enum الخاص بحالة الوثيقة المعرف بـ ['بانتظار المراجعة', 'مقبول', 'مرفوض'][cite: 23]
            'status' => $this->faker->randomElement(['بانتظار المراجعة', 'مقبول', 'مرفوض']),
        ];
    }
}
