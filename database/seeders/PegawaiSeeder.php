<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // List jabatan dengan jumlah pegawai yang diinginkan
        $jabatanList = [
            'Kepala Sekolah' => ['PNS' => 1, 'Honorer' => 0],
            'Wakil Kepala' => ['PNS' => 1, 'Honorer' => 0],
            'Guru' => ['PNS' => 10, 'Honorer' => 5],
            'Staff TU' => ['PNS' => 5, 'Honorer' => 2],
            'Staff' => ['PNS' => 0, 'Honorer' => 4],
        ];

        $dataPegawai = [];

        foreach ($jabatanList as $jabatan => $statusCounts) {
            foreach ($statusCounts as $status => $jumlah) {
                for ($i = 1; $i <= $jumlah; $i++) {
                    $dataPegawai[] = [
                        // 'nip' => ($jabatan !== 'Staff' && $status === 'PNS') ? $faker->numerify('1980##########') : null, // NIP hanya untuk PNS selain Staff
                        'nip' => ($status === 'PNS') ? $faker->numerify('1980##########') : null, // NIP hanya untuk PNS selain Staff
                        'name' => $faker->name,
                        'jk' => $faker->randomElement(['P', 'L']),
                        // 'telepon' => $faker->phoneNumber,
                        'alamat' => $faker->address,
                        'tanggal_lahir' => $faker->date('Y-m-d', '2000-12-31'),
                        'email' => $faker->unique()->safeEmail,
                        'status_kepegawaian' => $status,
                        'jabatan' => $jabatan,
                        'is_active' => true,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }
        }

        // Insert batch data ke tabel pegawais
        DB::table('pegawais')->insert($dataPegawai);
    }
}
