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
            'damage_description' => $this->faker->optional(0.5)->sentence(),
            'original_city' => $this->faker->randomElement(['غزة', 'بيت حانون', 'جباليا']),
            'current_displacement_destination' => $this->faker->address,
            'detailed_current_address' => 'بجوار مستشفى أو معالم بارزة في المنطقة السكنية الحالية',
        ];
    }
}
