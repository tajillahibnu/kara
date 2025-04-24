<?php

namespace Modules\Pkl\Services\Dashboard;

use App\Models\Pegawai;
use Exception;
use Illuminate\Support\Facades\Auth;

class GuruService
{
    public function readDashboard()
    {
        $aArrData = [];
        $user = Auth::user();
        try {
            $getSiswa = Pegawai::find($user->biodata_id);
            $aArrData = collect(optional($getSiswa)->toArray())->except(['id']); // Semua field Pegawai
        } catch (Exception $e) {
            throw new Exception("Failed to update item" . $e->getMessage(), 500);
        }
        return $aArrData;
    }
}
