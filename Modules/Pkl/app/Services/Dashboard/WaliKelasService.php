<?php

namespace Modules\Pkl\Services\Dashboard;

use App\Models\Rombel;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WaliKelasService
{
    public function readDashboard()
    {
        $aArrData = [];
        $user = Auth::user();
        try {
            // $getKelas = Rombel::where('walikelas_id', $user->biodata_id)->first();
            // $aArrData = collect(optional($getKelas)->toArray())->except(['id', 'jurusan_id', 'walikelas_id']); // Semua field Pegawai
            $queryKelas = DB::select("SELECT * FROM view_rombels WHERE walikelas_id = ?", [$user->id]);
            //Jika Mengunakan first
            $getKelas = collect($queryKelas)->first();
            $aArrData = collect((array) $getKelas)->except(['id', 'jurusan_id', 'walikelas_id']);
            
            //Jika Mengunakan data array lebih dari 1
            // $aArrData = collect($queryKelas)->map(function ($item) {
            //     return collect($item)->except(['id']);
            // });

            $getTotal = $this->totalSiswa($getKelas->id);
            $aArrData = $aArrData->merge($getTotal);
        } catch (Exception $e) {
            throw new Exception("Failed to update item" . $e->getMessage(), 500);
        }
        return $aArrData;
    }

    public function totalSiswa($kelas_id)
    {
        try {
            $result = DB::select("SELECT 
                COUNT(*) AS siswa,
                SUM(CASE WHEN jk = 'L' THEN 1 ELSE 0 END) AS pria,
                SUM(CASE WHEN jk = 'P' THEN 1 ELSE 0 END) AS wanita
            FROM siswas 
            WHERE rombel_id = ? 
                AND is_lulus = false
                AND is_active = true", [$kelas_id]);

            // Memeriksa apakah ada hasil
            if (!empty($result)) {
                foreach ($result as $value) {
                    foreach ($value as $key => $item) {
                        $aArrData['total'][$key] = $item;
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
