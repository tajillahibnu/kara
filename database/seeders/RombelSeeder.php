<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\Rombel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RombelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Ambil jurusan yang aktif saja
        // $jurusanAktif = Jurusan::where('is_active', true)->get();
        $jurusanAktif = Jurusan::all();

        foreach ($jurusanAktif as $jurusan) {
            // Buatkan tiga rombel untuk setiap jurusan aktif
            foreach (range(10, 12) as $tingkat) {
                Rombel::factory()->count(3)->create([
                    'name' => $jurusan->kode, // Sesuai kode jurusan
                    'tingkat_id' => $tingkat,
                    'jurusan_id' => $jurusan->id,
                    'is_active' => $jurusan->is_active,
                    'tipe' => 'KBM'
                ]);
            }
        }
    }
}
