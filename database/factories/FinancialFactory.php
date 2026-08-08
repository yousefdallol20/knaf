<?php

namespace Database\Factories;

use App\Models\financial_data;
use Illuminate\Database\Eloquent\Factories\Factory;

class FinancialFactory extends Factory
{
    protected $model = financial_data::class;

    public function definition(): array
    {
        return [
            'official_receiving_entity' => $this->faker->randomElement(['بنك فلسطين', 'شركة صرافة محلية', 'محفظة جوال بي']),
            'account_holder_name' => $this->faker->name,
            'bank_account_or_iban' => $this->faker->bankAccountNumber,

            // حل قيد الـ enum المالي المحدد بـ ['weak', 'medium', 'good'] في الميجريشن[cite: 22]
            'family_financial_status' => $this->faker->randomElement(['weak', 'medium', 'good']),
        ];
    }
}
