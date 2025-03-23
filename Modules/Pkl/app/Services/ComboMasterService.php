<?php

namespace Modules\Pkl\Services;

use App\Models\Jurusan;
use App\Models\PklPeriode;
use App\Models\Role;
use App\Models\Rombel;
use App\Models\TahunAkademik;
use App\Models\Tingkat;
use Illuminate\Support\Facades\Request;

class ComboMasterService
{

    public function kelas()
    {
        // Mengambil input dari request
        $input = Request::all(); // Mengambil semua input dari request

        // Ambil data dengan is_active = true
        $query = Rombel::select('id', 'name')
            ->where('is_active', true) // Filter data yang aktif
            ->whereNull('deleted_at'); // Pastikan data tidak dihapus (soft delete)

        // Tambahkan kondisi where untuk jurusan_id jika ada dalam request
        if (isset($input['jurusan_id'])) {
            $query->where('jurusan_id', $input['jurusan_id']);
        }

        if (isset($input['tingkat_id'])) {
            $query->where('tingkat_id', $input['tingkat_id']);
        }

        // Ambil data
        $data = $query->get();

        // Mengolah data
        return $data->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => ucwords($item->name),
            ];
        });
    }

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
        $data = Jurusan::select('id', 'name', 'kode')
            ->where('is_active', true) // Filter data yang aktif
            ->get();

        return $data->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => '[' . ucwords($item->kode) . '] ' . ucwords($item->name),
                'kode' => $item->kode,
            ];
        });
    }

    public function tahun_pelajaran()
    {
        $data = TahunAkademik::select('id', 'name')
            ->orderBy('id', 'DESC')
            ->get();
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

    public function priode_pkl()
    {
        $data = PklPeriode::select('id', 'name')
            ->where('is_active', true) // Filter data yang aktif
            ->orderBy('name', 'DESC')
            ->get();
        return $data->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => ucwords($item->name)
            ];
        });
    }
}
