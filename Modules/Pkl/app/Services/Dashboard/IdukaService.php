<?php

namespace Modules\Pkl\Services\Dashboard;

use Exception;
use Illuminate\Support\Facades\Auth;
use Modules\Pkl\Repositories\DudiRepository;

class IdukaService
{
    protected $repository;

    public function __construct(DudiRepository $repository)
    {
        $this->repository = $repository;
    }

    public function readDashboard()
    {

        try {
            $biodataId = Auth::user()->biodata_id;
            $getData = $this->repository->find($biodataId);
            $getData = collect(optional($getData)->toArray())->except(['id']); // Semua field Pegawai
            $getDashboard = $this->repository->infoDashboard($biodataId);
            $getData = $getData->merge($getDashboard);
        } catch (Exception $e) {
            throw new Exception("Failed to update item" . $e->getMessage(), 500);
        }
        return $getData;
    }
}
