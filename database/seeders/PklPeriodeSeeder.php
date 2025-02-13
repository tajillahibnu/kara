<?php

namespace Database\Seeders;

use App\Models\PklPeriode;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PklPeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PklPeriode::create([
            'name'  => 'Gelombang 1 Tahun 2025',
            'tahun_ajaran' => '2024/2025',
            'kuota_siswa' => 50,
            'batas_registrasi' => Carbon::parse('2024-06-30'),
            'syarat_pendaftaran' => 'Siswa harus minimal kelas 11, memiliki izin orang tua, dan memenuhi syarat administrasi.',
            'tanggal_mulai' => Carbon::parse('2024-07-15'),
            'tanggal_selesai' => Carbon::parse('2024-10-15'),
            'is_active' => false, // Pendaftaran dibuka
        ]);

        PklPeriode::create([
            'name'  => 'Gelombang 1 Tahun 2025',
            'tahun_ajaran' => '2025/2026',
            'kuota_siswa' => 60,
            'batas_registrasi' => Carbon::parse('2025-02-30'),
            'syarat_pendaftaran' => 'Siswa harus minimal kelas 11, memiliki izin orang tua, dan memenuhi syarat administrasi.',
            'tanggal_mulai' => Carbon::parse('2025-03-10'),
            'tanggal_selesai' => Carbon::parse('2025-06-10'),
            'is_active' => true, // Pendaftaran belum dibuka
        ]);

        PklPeriode::create([
            'name'  => 'Gelombang 1 Tahun 2025',
            'tahun_ajaran' => '2025/2026',
            'kuota_siswa' => 60,
            'batas_registrasi' => Carbon::parse('2025-06-30'),
            'syarat_pendaftaran' => 'Siswa harus minimal kelas 11, memiliki izin orang tua, dan memenuhi syarat administrasi.',
            'tanggal_mulai' => Carbon::parse('2025-07-10'),
            'tanggal_selesai' => Carbon::parse('2025-12-10'),
            'is_active' => false, // Pendaftaran belum dibuka
        ]);
    }
}
