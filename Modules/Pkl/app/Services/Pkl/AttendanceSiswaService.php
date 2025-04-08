<?php

namespace Modules\Pkl\Services\Pkl;

use App\Models\Attendance_pkl;
use App\Models\Siswa;
use App\Services\DataTableService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Modules\Pkl\Repositories\AttendanceSiswaRepository;
use Modules\Pkl\Repositories\BasePklRepository;

class AttendanceSiswaService
{
    protected $repository;
    public function __construct(
        AttendanceSiswaRepository $repository,
    ) {
        $this->repository = $repository;
    }

    public function getDataBy($siswaId, $date)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            $query = Attendance_pkl::where('siswa_id', $siswaId)
                ->where('tanggal', $date)
                ->limit(1);

            $getData = $query->first();
            $map['clock_in']    = $getData['clock_in'] ?? null;
            $map['clock_out']   = $getData['clock_out'] ?? null;
            $map['clock_in_real']   = $getData['clock_in_real'] ?? null;
            $map['clock_out_real']  = $getData['clock_out_real'] ?? null;
            $map['tahun_pelajaran'] = $getData['tahun_pelajaran'] ?? null;
            $map['durasi']      = $getData['durasi'] ?? null;
            $map['durasi_real'] = $getData['durasi_real'] ?? null;
            
            return $map;
        } catch (QueryException $e) {
            $response['statusCode'] = 400;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    public function ChekInOut(array $input, $siswaId)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            $dataToSave = [];
            $dataToSave['tanggal']      = date('Y-m-d');
            $dataToSave['note']         = $input['note'];
            $response = $this->repository->SaveInOut($dataToSave, $siswaId);
            $response['data'] = $input;
        } catch (QueryException $e) {
            $response['statusCode'] = 400;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    public function table($siswaId)
    {
        return DataTableService::draw('attendance_pkls')
            ->where('siswa_id', $siswaId)
            ->toJson();
    }
}
