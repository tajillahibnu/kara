<?php

namespace Modules\Pkl\Services;

use App\Models\Dudi;
use App\Models\Jurusan;
use App\Models\Pegawai;
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

    public function pegawai()
    {
        $input = Request::all(); // Mengambil semua input dari request
        $query = Pegawai::select('id', 'name')
            ->orderBy('name', 'ASC')
            ->whereNull('deleted_at');

        if (!empty($input)) {
            foreach ($input as $fild => $value) {
                $query->where($fild, $value);
            }
        }

        $query->where('is_active', true);
        $data = $query->get();
        return $data->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => ucwords($item->name)
            ];
        });
    }

    public function industri()
    {
        $query = Dudi::select('id', 'name')
            ->orderBy('name', 'DESC')
            ->whereNull('deleted_at');

        $query->where('is_active', true);

        $data = $query->get();
        return $data->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => ucwords($item->name)
            ];
        });
    }

    public function priode_pkl($isAll = true)
    {
        // Ambil data dengan is_active = true
        $query = PklPeriode::select('id', 'name')
            ->orderBy('name', 'DESC')
            ->whereNull('deleted_at'); // Pastikan data tidak dihapus (soft delete)

        // Tambahkan kondisi where untuk jurusan_id jika ada dalam request
        if (($isAll)) {
            $query->where('is_active', true);
        }

        // Ambil data
        $data = $query->get();
        return $data->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => ucwords($item->name)
            ];
        });
    }
}
