<?php

namespace Database\Seeders;

use App\Models\Tingkat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TingkatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tingkat::create(['code' => 1, 'is_active' => false, 'name' => 'satu', 'romawi' => 'I', 'tipe' => 'SD']);
        Tingkat::create(['code' => 2, 'is_active' => false, 'name' => 'dua', 'romawi' => 'II', 'tipe' => 'SD']);
        Tingkat::create(['code' => 3, 'is_active' => false, 'name' => 'tiga', 'romawi' => 'III', 'tipe' => 'SD']);
        Tingkat::create(['code' => 4, 'is_active' => false, 'name' => 'empat', 'romawi' => 'IV', 'tipe' => 'SD']);
        Tingkat::create(['code' => 5, 'is_active' => false, 'name' => 'lima', 'romawi' => 'V', 'tipe' => 'SD']);
        Tingkat::create(['code' => 6, 'is_active' => false, 'name' => 'enam', 'romawi' => 'VI', 'tipe' => 'SD']);
        Tingkat::create(['code' => 7, 'is_active' => true, 'name' => 'tujuh', 'romawi' => 'VII', 'tipe' => 'SMP']);
        Tingkat::create(['code' => 8, 'is_active' => true, 'name' => 'delapan', 'romawi' => 'VIII', 'tipe' => 'SMP']);
        Tingkat::create(['code' => 9, 'is_active' => true, 'name' => 'sembilan', 'romawi' => 'IX', 'tipe' => 'SMP']);
        Tingkat::create(['code' => 10, 'is_active' => false,  'name' => 'sepuluh', 'romawi' => 'X', 'tipe' => 'SMA']);
        Tingkat::create(['code' => 11, 'is_active' => false,  'name' => 'sebelas', 'romawi' => 'XI', 'tipe' => 'SMA']);
        Tingkat::create(['code' => 12, 'is_active' => false,  'name' => 'duabelas', 'romawi' => 'XII', 'tipe' => 'SMA']);
    }
}
