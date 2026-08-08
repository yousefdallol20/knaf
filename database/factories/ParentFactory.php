<?php

namespace Database\Factories;

use App\Models\Parents;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParentFactory extends Factory
{
    protected $model = Parents::class;

    public function definition(): array
    {
        $isMotherAlive = $this->faker->boolean(70);

        return [
            'name' => $this->faker->name('male'),
            'death_date' => $this->faker->date('Y-m-d', '-2 years'),
            'is_mother_alive' => $isMotherAlive,
            'mother_death_reason' => !$isMotherAlive ? $this->faker->randomElement(['مرض عضال', 'حادث سير', 'بسبب الحرب المستمرة']) : null,

            // أضف هذا السطر هنا لتوليد قيمة لشهادة الوفاة وتخطي قيد قاعدة البيانات
            'death_certificate' => 'death_cert_' . $this->faker->numberBetween(1000, 9999) . '.pdf',
        ];
    }
}
