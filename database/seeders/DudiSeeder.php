<?php

namespace Database\Seeders;

use App\Models\Dudi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat Dudi beserta DudiRule menggunakan factory
        Dudi::factory()
            ->count(5) // Membuat 5 Dudi
            ->create()
            ->each(function ($dudi) {
                $dudi->rules()->createMany([
                    ['rule_type' => 'max_siswa_motor', 'value' => 5],
                    ['rule_type' => 'max_siswa_perempuan', 'value' => 3],
                ]);
            });

        Dudi::create([
            'name' => 'PT. Software Indonesia',
            'address' => 'Jl. Teknologi No. 12, Jakarta',
            'phone' => '021-123456',
            'email' => 'info@softwareindonesia.com',
            'website' => 'https://softwareindonesia.com',
            'latitude' => -6.200000,
            'longitude' => 106.816666,
            'pic_name' => 'Budi Santoso',
            'pic_phone' => '08123456789',
            'quota' => 10,
            'sector' => 'Teknologi Informasi',
            'partnership_status' => 'Mitra Tetap',
            'description' => 'Perusahaan pengembang software dengan fokus pada aplikasi berbasis web dan mobile.',
            'requirements' => 'Siswa harus memiliki pemahaman dasar tentang pemrograman.',
            'is_active' => true
        ]);

        Dudi::create([
            'name' => 'Bengkel Motor Jaya',
            'address' => 'Jl. Otomotif No. 45, Bandung',
            'phone' => '022-7654321',
            'email' => 'bengkel@motorshop.com',
            'website' => null,
            'latitude' => -6.914744,
            'longitude' => 107.609810,
            'pic_name' => 'Dedi Supriatna',
            'pic_phone' => '08129876543',
            'quota' => 5,
            'sector' => 'Otomotif',
            'partnership_status' => 'Belum Ada MoU',
            'description' => 'Bengkel yang melayani perawatan dan perbaikan motor.',
            'requirements' => 'Siswa diutamakan yang memiliki dasar mekanik otomotif.',
            'is_active' => false
        ]);
    }
}
