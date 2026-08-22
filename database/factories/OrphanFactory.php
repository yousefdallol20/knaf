<?php

namespace Database\Factories;

use App\Models\orphans;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrphanFactory extends Factory
{
    protected $model = orphans::class;

    public function definition(): array
    {
        $gender = $this->faker->randomElement(['ذكر', 'أنثى']);
        $age = $this->faker->numberBetween(2, 17);

        $arabicMaleNames = ['أحمد', 'محمد', 'عمر', 'يوسف', 'خالد', 'محمود', 'علي', 'حسين', 'إبراهيم', 'مصطفى'];
        $arabicFemaleNames = ['فاطمة', 'عائشة', 'مريم', 'زينب', 'سارة', 'نور', 'أبرار', 'جنى', 'شهد', 'سلمى'];
        $arabicLastNames = ['النابلسي', 'المصري', 'الشهابي', 'النجار', 'الحاج', 'البرغوثي', 'الخليل', 'صالح', 'العمري'];

        $firstName = $gender === 'ذكر'
            ? $this->faker->randomElement($arabicMaleNames)
            : $this->faker->randomElement($arabicFemaleNames);

        $fatherName = $this->faker->randomElement($arabicMaleNames);
        $lastName = $this->faker->randomElement($arabicLastNames);
        $fullName = "{$firstName} {$fatherName} {$lastName}";

        return [
            'first_name' => $firstName,
            'name'       => $fullName,
            'national_id' => $this->faker->unique()->regexify('[0-9]{9}'),
            'birth_date' => now()->subYears($age)->subMonths($this->faker->numberBetween(1, 11))->format('Y-m-d'),
            'age' => $age,
            'gender' => $gender,
            'education_level' => $age < 6 ? 'رياض أطفال' : ($age < 12 ? 'ابتدائي' : ($age < 15 ? 'إعدادي' : 'ثانوي')),
            'orphan_location_status' => $this->faker->randomElement(['نازح', 'مقيم', 'في مركز إيواء']),

            'is_double_orphan' => $this->faker->boolean(20),
            'is_sole_breadwinner' => $this->faker->boolean(10),
            'is_critically_needy' => $this->faker->boolean(60),
            'is_war_injured' => $this->faker->boolean(15),
            'has_chronic_disease' => $this->faker->boolean(15),

            'health_status' => $this->faker->randomElement(['سليم', 'مستقر', 'بحاجة لمتابعة مستمرة', 'حرجة']),
            'health_description' => $this->faker->optional(0.3)->sentence(),
            'story' => 'هذا الطفل فقد معيله الأساسي ويعيش ظروفاً استثنائية صعبة نتيجة النزوح المستمر، ويحتاج إلى كفالة شهرية لتغطية مصاريف التعليم والاحتياجات الأساسية.',
            'birth_certificate_path' => 'cert_' . $this->faker->numberBetween(1000, 9999) . '.pdf',
            'personal_photo_path' => 'orphan_' . $this->faker->numberBetween(1, 10) . '.jpg',

            'data_acknowledgement' => true,
            'country' => 'فلسطين',
            'city' => $this->faker->randomElement(['غزة', 'خانيونس', 'رفح', 'دير البلح', 'شمال غزة']),

            'status' => $this->faker->randomElement(['بانتظار القبول']),
            'urgency_level' => $this->faker->randomElement(['متوسطة', 'حرجة', 'عاجلة جداً']),
            'required_amount' => $this->faker->randomElement([50.00, 75.00, 100.00, 150.00]),
        ];
    }
}
