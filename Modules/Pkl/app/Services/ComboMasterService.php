<?php

namespace Modules\Pkl\Services;

use App\Models\Jurusan;
use App\Models\Role;
use App\Models\TahunAkademik;
use App\Models\Tingkat;

class ComboMasterService
{

    public function tingkat()
    {
        // Hanya ambil data dengan is_active = true
        $data = Tingkat::select('id', 'name', 'romawi')
            ->where('is_active', true) // Filter data yang aktif
            ->get();

        return $data->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => ucwords($item->name),
                'romawi' => ucwords($item->romawi)
            ];
        });
    }

    public function jurusan()
    {
        // Hanya ambil data dengan is_active = true
        $data = Jurusan::select('id', 'name','kode')
            ->where('is_active', true) // Filter data yang aktif
            ->get();

        return $data->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => '['.ucwords($item->kode).'] '.ucwords($item->name),
                'kode' => $item->kode,
            ];
        });
    }

    public function tahun_pelajaran()
    {
        $data = TahunAkademik::select('id', 'name')->get();
        return $data->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => ucwords($item->name)
            ];
        });
    }

    public function roles()
    {
        $data = Role::select('id', 'name')->get();
        return $data->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => ucwords($item->name)
            ];
        });
    }
}
