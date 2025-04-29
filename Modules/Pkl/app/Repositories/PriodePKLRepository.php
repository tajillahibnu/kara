<?php

namespace Modules\Pkl\Repositories;

use App\Models\Dudi;
use App\Models\Jurusan;
use App\Models\JurusanPriodePkl;
use App\Models\PklPeriode;
use App\Models\PklPriodeInduka;
use App\Repositories\BaseRepository;

class PriodePKLRepository extends BaseRepository
{
    public function __construct(PklPeriode $model)
    {
        parent::__construct($model);
    }

    public function fetchInduka()
    {
        return Dudi::select('id', 'name')
            ->where('is_active', true)
            ->get();
    }

    public function fetchKompt()
    {
        return Jurusan::select('id', 'name', 'kode')
            ->where('is_active', true)
            ->get();
    }

    public function fetchPriodeKompt($priodeId)
    {
        return JurusanPriodePkl::select(
            'jurusans.id',
            'jurusans.name',
            'jurusans.kode')
            ->join('jurusans', 'jurusans.id', '=', 'jurusan_priode_pkls.jurusan_id')
            ->where('jurusans.is_active', true)
            ->where('jurusan_priode_pkls.periode_id', $priodeId)
            ->get();
    }

    public function indukaToPriode($data)
    {
        $priode = PklPriodeInduka::withTrashed()
            ->where($data)
            ->first();

        if ($priode && $priode->trashed()) {
            // Kembalikan data yang terhapus
            $priode->restore();
            // Update data kalau perlu
            // $user->update($request->only(['name', 'email']));
        } else {
            $priode = PklPriodeInduka::updateOrCreate($data);
        }

        return $priode;
    
    }


    public function jurusanToPriode($data)
    {
        $priode = JurusanPriodePkl::withTrashed()
            ->where($data)
            ->first();

        if ($priode && $priode->trashed()) {
            // Kembalikan data yang terhapus
            $priode->restore();
            // Update data kalau perlu
            // $user->update($request->only(['name', 'email']));
        } else {
            $priode = JurusanPriodePkl::updateOrCreate($data);
        }

        return $priode;
    }
    public function deleteKompt($id)
    {
        $query = JurusanPriodePkl::find($id);
        if ($query) {
            $query->delete();
        }

        return $query;
    }
}
