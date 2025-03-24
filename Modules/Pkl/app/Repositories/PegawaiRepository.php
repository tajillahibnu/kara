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

            $pass = $pegawai->nip ?? 'password123';
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

    public function pegawaiToUpdate(array $dataToUpdate, $identifier = null, callable $userCallback = null)
    {
        DB::beginTransaction();
        try {
            if (isset($dataToUpdate['email'])) {
                $exists = User::where('email', $dataToUpdate['email'])
                    ->where('id', '!=', $identifier) // Pastikan bukan dirinya sendiri
                    ->exists();
    
                if ($exists) {
                    throw new \Exception("Email sudah digunakan oleh pengguna lain.");
                }
            }
    
            // Update pegawai terlebih dahulu
            $updated = false;
            if ($identifier && !empty($dataToUpdate)) {
                $updated = Pegawai::where('id', $identifier)->update($dataToUpdate);
                // Ambil data terbaru setelah update
            }
            $pegawai = Pegawai::find($identifier);

            // Jika update pegawai berhasil dan ada callback, jalankan callback
            if ($updated && $userCallback !== null) {
                $userCallback($pegawai->toArray()); // Callback dipanggil tanpa parameter
            }

            DB::commit();
            return $updated;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }



    // public function pegawaiToUpdate(array $dataToUpdate, $identifier = null, $userId = null, array $userToUpdate = [])
    // {
    //     DB::beginTransaction(); // Mulai transaction
    //     try {
    //         // Update user jika userId dan userToUpdate tidak kosong
    //         if ($userId && !empty($userToUpdate)) {
    //             User::where('id', $userId)->update($userToUpdate);
    //         }

    //         // Update pegawai jika identifier dan dataToUpdate tidak kosong
    //         $updated = false;
    //         if ($identifier && !empty($dataToUpdate)) {
    //             $updated = Pegawai::where('id', $identifier)->update($dataToUpdate);
    //         }

    //         DB::commit(); // Simpan perubahan ke database
    //         return $updated; // Kembalikan status update (true jika berhasil, false jika tidak)
    //     } catch (\Exception $e) {
    //         DB::rollBack(); // Batalkan semua perubahan jika ada error
    //         throw $e;
    //     }
    // }
}
