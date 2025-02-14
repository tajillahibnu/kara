<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\Rombel;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar jurusan yang tersedia
        $jurusanList = Jurusan::pluck('id', 'kode');

        foreach ($jurusanList as $namaJurusan => $jurusanId) {
            $this->command->info("Menambahkan siswa untuk jurusan: $namaJurusan");

            $this->seedSiswa(20, '10', $jurusanId);
            $this->seedSiswa(20, '11', $jurusanId);
            $this->seedSiswa(20, '12', $jurusanId);
        }
    }

    private function seedSiswa($jumlah, $tingkat,$jurusanId)
    {
        $faker = Faker::create('id_ID');

        // Ambil daftar rombel berdasarkan tingkat
        // Ambil daftar rombel berdasarkan tingkat dan jurusan yang memiliki kapasitas
        $rombels = Rombel::where('tingkat_id', $tingkat)
                        ->where('jurusan_id', $jurusanId)
                        ->whereColumn('kapasitas', '>', DB::raw('(SELECT COUNT(*) FROM siswas WHERE siswas.rombel_id = rombels.id)'))
                        ->orderBy('id') // Urutkan biar sistematis
                        ->get();
        // $rombels = Rombel::where('tingkat_id', $tingkat)
        // ->where('jurusan_id',$jurusanId)
        // ->get();
        if ($rombels->isEmpty()) {
            $this->command->warn("Tidak ada rombel untuk tingkat $tingkat.");
            return;
        }

        for ($i = 0; $i < $jumlah; $i++) {
            // // Pilih salah satu rombel secara acak untuk tingkat yang sesuai
            // $rombel = $rombels->random();

            // Cari rombel dengan kapasitas tersisa
            $rombel = $this->getAvailableRombel($rombels);
            $rombelId = $rombel ? $rombel->id : null; // Jika tidak ada kelas, set null

            if (!$rombel) {
                $this->command->warn("Semua kelas untuk tingkat $tingkat jurusan ID $jurusanId sudah penuh!");
                // break;
            }

            // Buat Siswa lebih dulu (Master)
            $siswa = Siswa::create([
                'nis'           => 'NIS' . $faker->unique()->numerify('########'),
                'name'          => $faker->name,
                'tanggal_lahir' => $faker->date(),
                'jk'            => $faker->randomElement(['L', 'P']),
                'alamat'        => $faker->address,
                'telepon'       => $faker->phoneNumber,
                'jurusan_id'    => $jurusanId,
                'tingkat_id'    => $tingkat,
                'email'         => $faker->unique()->safeEmail,
                'is_active'     => true,
                'rombel_id'     => $rombelId, // Masukkan ke rombel yang sesuai
            ]);

            // // Buat User dengan biodata_id merujuk ke Siswa
            // User::create([
            //     'name'       => $siswa->name,
            //     'username'   => $siswa->nis,
            //     'username'   => $this->generateUniqueUsername($siswa->nama),
            //     'email'      => $faker->unique()->safeEmail,
            //     'password'   => bcrypt($siswa->nis),
            //     'biodata_id' => $siswa->id, // Relasi ke siswa
            //     'primary_role_id' => 4,
            //     'is_siswa'  => true
            // ]);
        }
    }

    private function getAvailableRombel($rombels)
    {
        foreach ($rombels as $rombel) {
            // Hitung jumlah siswa dalam rombel
            $siswaCount = Siswa::where('rombel_id', $rombel->id)->count();
            if ($siswaCount < $rombel->kapasitas) {
                return $rombel;
            }
        }
        return null; // Jika semua rombel penuh
    }


    private function generateUniqueUsername($nama)
    {
        do {
            $username = 'S-' . str_pad(rand(1, 999), 4, '0', STR_PAD_LEFT);
        } while (User::where('username', $username)->exists());

        return $username;
    }
}
