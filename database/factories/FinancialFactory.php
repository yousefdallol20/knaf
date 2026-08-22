<?php

namespace Database\Factories;

use App\Models\financial_data;
use Illuminate\Database\Eloquent\Factories\Factory;

class FinancialFactory extends Factory
{
    protected $model = financial_data::class;

    public function definition(): array
    {
        $arabicNames = ['محمد أحمد الأحمد', 'محمود عبد الرحمن الخالدي', 'فاطمة الزهراء البكري'];

        return [
            'official_receiving_entity' => $this->faker->randomElement(['بنك فلسطين', 'شركة صرافة محلية', 'محفظة جوال بي']),
            'account_holder_name' => $this->faker->randomElement($arabicNames),
            'bank_account_or_iban' => $this->faker->bankAccountNumber,
            'family_financial_status' => $this->faker->randomElement(['weak', 'medium', 'good']),
        ];
    }
}
