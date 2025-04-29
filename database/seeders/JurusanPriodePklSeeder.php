<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\JurusanPriodePkl;
use App\Models\PklPeriode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JurusanPriodePklSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fetchKompt = Jurusan::where('is_active', true)->get();
        $fetchPriod = PklPeriode::where('is_active', true)->get();

        foreach ($fetchPriod as $key => $priode) {
            $save['periode_id'] = $priode->id;
            foreach ($fetchKompt as $kompt) {
                $save['jurusan_id'] = $kompt->id;
                JurusanPriodePkl::create($save);
            }
        }
    }
}
