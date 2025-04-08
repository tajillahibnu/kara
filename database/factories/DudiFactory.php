<?php

namespace Database\Factories;

use App\Models\Dudi;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dudi>
 */
class DudiFactory extends Factory
{
    protected static ?string $password;
    protected $model = Dudi::class;

    public function definition()
    {
        return [
            'jurusan_id' => $this->faker->numberBetween(1, 3),
            'name' => $this->faker->company,
            'username' => $this->faker->unique()->userName,
            'password' => static::$password ??= Hash::make('password@123'),
            'address' => $this->faker->address,
            'email' => fake()->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'pic_name' => fake()->name(),
            'pic_jabatan' => 'Kepala Produksi',
            'pic_phone' => $this->faker->phoneNumber(),
            'description' => $this->faker->paragraph,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];
    }
}
