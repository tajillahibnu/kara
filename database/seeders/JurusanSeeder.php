<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusanSmkData = [
            [
                'kode' => 'TKJ',
                'name' => 'Teknik Komputer dan Jaringan',
                'bidang_keahlian' => 'Teknologi Informasi dan Komunikasi',
                'program_keahlian' => 'Teknik Komputer dan Informatika',
                'deskripsi' => 'Fokus pada jaringan komputer, perangkat keras, dan administrasi jaringan.',
                'is_active' => true,
            ],
            [
                'kode' => 'RPL',
                'name' => 'Rekayasa Perangkat Lunak',
                'bidang_keahlian' => 'Teknologi Informasi dan Komunikasi',
                'program_keahlian' => 'Teknik Komputer dan Informatika',
                'deskripsi' => 'Berorientasi pada pengembangan perangkat lunak dan sistem berbasis IT.',
                'is_active' => true,
            ],
            [
                'kode' => 'TKR',
                'name' => 'Teknik Kendaraan Ringan',
                'bidang_keahlian' => 'Teknologi dan Rekayasa',
                'program_keahlian' => 'Teknik Otomotif',
                'deskripsi' => 'Fokus pada perawatan dan perbaikan kendaraan bermotor.',
                'is_active' => true,
            ],
            [
                'kode' => 'TBSM',
                'name' => 'Teknik dan Bisnis Sepeda Motor',
                'bidang_keahlian' => 'Teknologi dan Rekayasa',
                'program_keahlian' => 'Teknik Otomotif',
                'deskripsi' => 'Memadukan teknik otomotif dengan bisnis di bidang sepeda motor.',
                'is_active' => false,
            ],
        ];

        foreach ($jurusanSmkData as $data) {
            DB::table('jurusans')->insert([
                'kode' => $data['kode'],
                'name' => $data['name'],
                'bidang_keahlian' => $data['bidang_keahlian'],
                'program_keahlian' => $data['program_keahlian'],
                'deskripsi' => $data['deskripsi'],
                'is_active' => $data['is_active'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
