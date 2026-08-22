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
            'file_path' => 'c:\xampp\htdocs\Archive\public\Uploads\guardians\default.png',
            'status' => $this->faker->randomElement(['مقبول', 'بانتظار المراجعة']),
        ];
    }
}
