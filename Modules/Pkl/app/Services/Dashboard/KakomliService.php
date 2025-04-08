<?php

namespace Modules\Pkl\Services\Dashboard;

use App\Models\Jurusan;
use App\Models\Rombel;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KakomliService
{
    public function readDashboard()
    {
        $aArrData = [];
        $user = Auth::user();
        try {
            $getJurusan = Jurusan::where('kakomli_id', $user->biodata_id)->first();
            $aArrData = collect(optional($getJurusan)->toArray())->except(['id']); // Semua field Pegawai

            $getTotal = $this->totalSiswa($getJurusan->id);
            $getTotal['total']['kelas'] = Rombel::where('jurusan_id', $getJurusan->id)->count();
            $aArrData = $aArrData->merge($getTotal);
        } catch (Exception $e) {
            throw new Exception("Failed to update item" . $e->getMessage(), 500);
        }
        return $aArrData;
    }

    public function totalSiswa($jurusan_id)
    {
        try {
            $result = DB::select("SELECT 
                COUNT(*) AS siswa,
                SUM(CASE WHEN jk = 'L' THEN 1 ELSE 0 END) AS pria,
                SUM(CASE WHEN jk = 'P' THEN 1 ELSE 0 END) AS wanita
            FROM siswas 
            WHERE jurusan_id = ? 
                AND is_lulus = false
                AND is_active = true", [$jurusan_id]);

            // Memeriksa apakah ada hasil
            if (!empty($result)) {
                foreach ($result as $value) {
                    foreach ($value as $key => $item) {
                        $aArrData['total'][$key] = (int) $item; // Casting ke integer
                    }
                }
            } else {
                $aArrData['total'] = []; // Atau bisa diisi dengan nilai default
            }
        } catch (Exception $e) {
            throw new Exception("Failed to update item" . $e->getMessage(), 500);
        }
        return $aArrData;
    }
}
