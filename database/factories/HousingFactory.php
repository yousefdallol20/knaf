<?php

namespace Database\Factories;

use App\Models\Housing;
use Illuminate\Database\Eloquent\Factories\Factory;

class HousingFactory extends Factory
{
    protected $model = Housing::class;

    public function definition(): array
    {
        return [
            'current_housing_type' => $this->faker->randomElement(['شقة إيجار', 'خيمة في مخيم', 'منزل متضرر', 'مركز إيواء']),
            'housing_condition' => $this->faker->randomElement(['سليم نسبياً', 'متضرر جزئياً', 'غير صالح للسكن']),
            'damage_description' => $this->faker->optional(0.5)->randomElement(['تضررت بعض الغرف', 'أضرار طفيفة في البناء']),
            'original_city' => $this->faker->randomElement(['غزة', 'بيت حانون', 'جباليا']),
            'current_displacement_destination' => $this->faker->randomElement(['دير البلح - شارع النخيل', 'خانيونس - الحي السعودي', 'رفح - المخيم الغربي']),
            'detailed_current_address' => 'بجوار مستشفى أو معالم بارزة في المنطقة السكنية الحالية',
        ];
    }
}
