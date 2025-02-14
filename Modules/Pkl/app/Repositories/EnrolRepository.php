<?php

namespace Modules\Pkl\Repositories;

use App\Models\RiwayatKelasSiswa;
use App\Models\Siswa;
use App\Models\TahunAkademik;
use Illuminate\Support\Facades\DB;

class EnrolRepository
{
    public function siswaToKelas($rombelId, $siswaId)
    {
        DB::beginTransaction();

        try {
            // Ambil tahun akademik aktif
            $tahun = TahunAkademik::where('is_active', true)->first();

            if (!$tahun) {
                throw new \Exception('Tahun akademik aktif tidak ditemukan.');
            }

            // Cek apakah siswa sudah ada di kelas yang sama
            $siswa = Siswa::find($siswaId);
            $currentRombel = $siswa->rombel_id;

            // Update rombel siswa
            $updateStatus = $siswa->update(['rombel_id' => $rombelId]);

            if ($updateStatus) {
                // Menentukan tanggal masuk dan keluar
                $tanggalMasuk = now()->toDateString();  // Tanggal siswa masuk kelas
                $tanggalKeluar = null;  // Tidak ada tanggal keluar, karena siswa masih berada di kelas

                // Jika siswa sudah ada riwayat kelas sebelumnya, set tanggal keluar
                if ($currentRombel) {
                    RiwayatKelasSiswa::where('siswa_id', $siswaId)
                        ->where('rombel_id', $currentRombel)
                        ->whereNull('tanggal_keluar')
                        ->update(['tanggal_keluar' => now()->toDateString()]);
                }

                // Simpan riwayat kelas siswa
                RiwayatKelasSiswa::create([
                    'siswa_id' => $siswaId,
                    'status_kelas_id' => 1,  // Misalnya status kelas 'aktif'
                    'rombel_id' => $rombelId,
                    'tahun_ajaran' => $tahun->name,
                    'tanggal_masuk' => $tanggalMasuk, // Menyimpan tanggal masuk
                    'tanggal_keluar' => $tanggalKeluar // Menyimpan tanggal keluar, saat ini null
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Siswa berhasil dipindahkan ke kelas baru dan riwayat kelas tercatat.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
