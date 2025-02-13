<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jurusan>
 */
class JurusanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode' => strtoupper($this->faker->unique()->lexify('?????')), // Random 5-character code
            'name' => $this->faker->words(3, true), // Random name with 3 words
            'deskripsi' => $this->faker->optional()->paragraph(),
            'is_active' => true,
        ];
    }
}
