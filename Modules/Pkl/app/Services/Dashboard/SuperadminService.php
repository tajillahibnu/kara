<?php

namespace Modules\Pkl\Services\Dashboard;

use App\Models\Pegawai;
use App\Models\Rombel;
use App\Models\Siswa;

class SuperadminService
{
    public function info()
    {
        $querySiswa = Siswa::withoutTrashed()->get();
        $dataJurusan = $this->totalSiswaJurusan();
        $data = [
            'totalSiswa'        => $querySiswa->count(),
            'siswaLaki'         => $querySiswa->where('jk', 'L')->count(),
            'siswaPerempuan'    => $querySiswa->where('jk', 'P')->count(),
            'tahunMasuk'        => Siswa::selectRaw('
                tahun_masuk, 
                COUNT(*) as total, 
                SUM(CASE WHEN jk = "L" THEN 1 ELSE 0 END) as total_laki, 
                SUM(CASE WHEN jk = "P" THEN 1 ELSE 0 END) as total_perempuan
            ')->groupBy('tahun_masuk')->get(),
            'totalSiswaJurusan' => $dataJurusan,
            'totalJurusan'      => count($dataJurusan),
            'jumlahLulus'       => $querySiswa->where('is_lulus', true)->count(),
            'totalRombel'       => Rombel::withoutTrashed()->count(),
            'totalPegawai'      => Pegawai::withoutTrashed()->count(),
        ];
        return $data;
    }

    private function totalSiswaJurusan()
    {
        $totalSiswaJurusan = Siswa::selectRaw('
        siswas.tahun_masuk, 
        jurusans.kode, 
        jurusans.name as nama_jurusan, 
        COUNT(siswas.id) as total, 
        SUM(CASE WHEN siswas.jk = "L" THEN 1 ELSE 0 END) as total_laki, 
        SUM(CASE WHEN siswas.jk = "P" THEN 1 ELSE 0 END) as total_perempuan
        ')
            ->withoutTrashed()
            ->join('jurusans', 'jurusans.id', '=', 'siswas.jurusan_id')
            ->groupBy('siswas.tahun_masuk', 'jurusans.name', 'jurusans.kode')
            ->orderBy('jurusans.name', 'asc')
            ->orderBy('siswas.tahun_masuk', 'asc')
            ->get();

        // Kelompokkan berdasarkan nama jurusan
        $groupedData = $totalSiswaJurusan->groupBy('nama_jurusan')->map(function ($items, $jurusan) {
            return [
                'name'           => $jurusan,
                'kode'           => $items->first()->kode, // Menambahkan kode jurusan
                'total'          => $items->sum('total'), // Total seluruh siswa di jurusan ini
                'total_laki'     => $items->sum('total_laki'), // Total seluruh siswa laki-laki di jurusan ini
                'total_perempuan' => $items->sum('total_perempuan'), // Total seluruh siswa perempuan di jurusan ini
                'siswa'          => $items->map(function ($item) {
                    return [
                        'tahun_masuk'     => $item->tahun_masuk,
                        'nama_jurusan'    => $item->nama_jurusan,
                        'total'           => $item->total,
                        'total_laki'      => $item->total_laki,
                        'total_perempuan' => $item->total_perempuan
                    ];
                })->toArray()
            ];
        })->values(); // Agar hasilnya berupa array tanpa key string

        // Return hasil dalam format yang diinginkan
        return $groupedData;

        // // Kelompokkan berdasarkan nama jurusan
        // $groupedData = $totalSiswaJurusan->groupBy('nama_jurusan');

        // // Return hasil dalam bentuk array
        // return $groupedData;
    }
}
