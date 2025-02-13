<?php

namespace Database\Seeders;

use App\Models\TahunAkademik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahunAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menambah data Tahun Akademik
        $academicYear = TahunAkademik::create([
            'name' => '2022/2023',
            'is_active' => false
        ]);
        $academicYear = TahunAkademik::create([
            'name' => '2023/2024',
            'is_active' => false
        ]);
        $academicYear = TahunAkademik::create([
            'name' => '2024/2025',
            'is_active' => false
        ]);
        $academicYear = TahunAkademik::create([
            'name' => '2025/2026',
            'is_active' => true
        ]);
    }
}
