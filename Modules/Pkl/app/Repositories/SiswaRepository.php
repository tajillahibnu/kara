<?php

namespace Modules\Pkl\Repositories;

use App\Models\Siswa;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiswaRepository extends BaseRepository
{
    public function __construct(Siswa $model)
    {
        parent::__construct($model);
    }

    public function createSiswa(array $data)
    {
        DB::beginTransaction(); // Mulai transaction

        try {
            // Simpan data pegawai
            $siswa = Siswa::create($data);

            // Generate username unik
            $username = $this->generateUniqueUsername($siswa->nis);

            $pass = $pegawai->nip ?? 'password123';
            // Buat user secara otomatis
            $user = User::create([
                'name'       => $siswa->name,
                'username'   => $username, // Gunakan username yang sudah dibuat
                'email'      => $siswa->email,
                'password'   => Hash::make($pass), // Bisa pakai default password atau dari request
                'biodata_id' => $siswa->id,
                'is_siswa'          => true,
                'primary_role_id'   => 4,
            ]);

            DB::commit(); // Simpan perubahan ke database

            return $siswa; // Kembalikan data pegawai
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua perubahan jika ada error
            throw $e;
        }
    }

    private function generateUniqueUsername($nama)
    {
        do {
            $username = str_pad(rand(1, 999), 6, '0', STR_PAD_LEFT);
        } while (User::where('username', $username)->exists()); // Cek ke database, kalau sudah ada, ulangi

        return $username;
    }

    public function deleteSiswa($id)
    {
        DB::beginTransaction(); // Mulai transaksi database

        try {
            // Cari siswa berdasarkan ID
            $siswa = Siswa::findOrFail($id);

            // Hapus siswa (soft delete)
            $siswa->delete();

            // Hapus user terkait (soft delete)
            User::where('biodata_id', $siswa->id)->delete();

            DB::commit(); // Simpan perubahan jika tidak ada error
            return ['success' => true, 'message' => 'Siswa dan user berhasil dihapus.'];
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua perubahan jika terjadi error

            return ['success' => false, 'message' => 'Gagal menghapus siswa.'];
        }
    }
}
