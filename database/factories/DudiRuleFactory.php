<?php

namespace Database\Factories;

use App\Models\Dudi;
use App\Models\DudiRule;
use App\Models\DudiRules;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DudiRule>
 */
class DudiRuleFactory extends Factory
{
    protected $model = DudiRules::class;

    public function definition()
    {
        return [
            'dudi_id' => Dudi::factory(), // Menggunakan factory untuk membuat Dudi terlebih dahulu
            'rule_type' => $this->faker->randomElement(['max_siswa_motor', 'max_siswa_perempuan']),
            'value' => $this->faker->numberBetween(1, 10),
        ];
    }
}
