<?php

namespace Modules\Pkl\Services\Dashboard;

use App\Models\Jurusan;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardSiswaService
{
    public function getBiodata()
    {
        $biodataId = Auth::user()->biodata_id;
        $getSiswa = Siswa::find($biodataId);
        $dataSiswa = collect(optional($getSiswa)->toArray())->except(['id']); // Semua field Pegawai

        $user = User::with('role')->where('id', Auth::id())->first();

        $jurusanNeme = '';
        if (!empty($getSiswa->jurusan_id)) {
            $jurusan = Jurusan::where('id', $getSiswa->jurusan_id)->first();
            $jurusanNeme = $jurusan->name;
        }
        $dataSiswa = $dataSiswa->merge(['jurusan_name' => $jurusanNeme]);

        // Ubah ke Collection
        $userData = collect(optional($user)->toArray())->only(['username', 'primary_role_id']); // Filter hanya field tertentu dari User

        // Tambahkan name dari role
        $userData->put('role_name', optional($user->role)->name);

        // Gabungkan Data Pegawai dan Data User
        $result = $dataSiswa->merge($userData);
        $result = $result->except(['jurusan_id', 'rombel_id','tingkat_id','primary_role_id']);

        // Return JSON Response
        return $result;
    }

    public function check_pkl_period(){
        
    }
}
