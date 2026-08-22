<?php

namespace Database\Factories;

use App\Models\guardian;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuardianFactory extends Factory
{
    protected $model = guardian::class;

    public function definition(): array
    {
        $arabicNames = [
            'خديجة عبد الله النابلسي', 'سميرة محمود العلي', 'وفاء إبراهيم النجّار',
            'كمال حسن المصري', 'أحمد محمود البرغوثي', 'مريم خالد الشهابي'
        ];

        return [
            'user_id' => User::factory(),
            'name' => $this->faker->randomElement($arabicNames),
            'national_id' => $this->faker->unique()->regexify('[0-9]{9}'),
            'birth_date' => $this->faker->date('Y-m-d', '-30 years'),
            'kinship_relation' => $this->faker->randomElement(['أم', 'عم', 'خال', 'جد', 'جدة']),
            'marital_status' => $this->faker->randomElement(['متزوج', 'أعزب', 'أرمل', 'مطلق']),
            'health_status' => $this->faker->randomElement(['سليم', 'مريض']),
            'health_details' => $this->faker->optional(0.2)->sentence(),
            'income_source' => $this->faker->randomElement(['مساعدات خارجية', 'عمل أجر يومي', 'لا يوجد']),
            'guardian_id_image' => 'guardian_id_' . $this->faker->numberBetween(1000, 9999) . '.jpg',
            'legal_guardianship_document' => 'legal_doc_' . $this->faker->numberBetween(1000, 9999) . '.pdf',
        ];
    }
}
