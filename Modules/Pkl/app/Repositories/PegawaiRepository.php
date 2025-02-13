<?php

namespace Modules\Pkl\Repositories;

use App\Models\Pegawai;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PegawaiRepository extends BaseRepository
{
    public function __construct(Pegawai $model)
    {
        parent::__construct($model);
    }

    public function createPegawai(array $save)
    {
        DB::beginTransaction(); // Mulai transaction

        try {
            // Simpan data pegawai
            $pegawai = Pegawai::create($save);

            // Generate username unik
            $username = $this->generateUniqueUsername($pegawai->nama);

            $pass = $pegawai->nip??'password123';
            // Buat user secara otomatis
            $user = User::create([
                'name'       => $pegawai->name,
                'username'   => $username, // Gunakan username yang sudah dibuat
                'email'      => $pegawai->email,
                'password'   => Hash::make($pass), // Bisa pakai default password atau dari request
                'biodata_id' => $pegawai->id,
                'is_siswa'          => false,
                'primary_role_id'   => $pegawai->jabatan == 'Staff' ? 3 : 7,
            ]);

            DB::commit(); // Simpan perubahan ke database

            return $pegawai; // Kembalikan data pegawai
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua perubahan jika ada error
            throw $e;
        }
    }

    private function generateUniqueUsername($nama)
    {
        do {
            $username = 'ROM-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        } while (User::where('username', $username)->exists()); // Cek ke database, kalau sudah ada, ulangi

        return $username;
    }
}
