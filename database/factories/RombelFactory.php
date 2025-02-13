<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rombel>
 */
class RombelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode' => $this->faker->unique()->bothify('ROM-###'),
            // 'name' => $this->faker->randomElement(['TKJ', 'RPL', 'TKR']),
            // 'walikelas_id' => 1, // Update sesuai kebutuhan relasi
            // 'jurusan_id' => 1, // Update sesuai kebutuhan relasi
            // 'tingkat' => $this->faker->numberBetween(10, 12),
            // 'tingkat' => $this->faker->numberBetween(10, 12),
            'kapasitas' => $this->faker->numberBetween(2, 5),
            'tahun_ajaran' => '2024/2025',
        ];

    }
}
