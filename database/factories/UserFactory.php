<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => $this->faker->unique()->userName,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password@123'),
            'remember_token' => Str::random(10),
            'primary_role_id' => '1',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function karyawan()
    {
        return $this->state(function (array $attributes) {
            return [
                'primary_role_id' => '3',
                'is_siswa' => false,
                'is_active' => true,
            ];
        });
    }

    public function siswa()
    {
        return $this->state(function (array $attributes) {
            return [
                'primary_role_id' => '4',
                'is_siswa' => true,
                'is_active' => true,
            ];
        });
    }

}
