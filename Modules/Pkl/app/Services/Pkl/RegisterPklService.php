<?php

namespace Modules\Pkl\Services\Pkl;

use App\Models\PklPeriode;
use App\Models\Siswa;
use App\Services\DataTableService;
use Illuminate\Database\QueryException;
use Modules\Pkl\Repositories\RegisterPklRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RegisterPklService
{
    protected $repository;

    public function __construct(
        RegisterPklRepository $repository,
    ) {
        $this->repository = $repository;
    }

    public function register(array $input)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            if (empty($input['siswa_id'])) {
                $response['statusCode'] = 400;
                $response['message'] = "Siswa Belum Dipilih";
            } else {
                foreach ($input['siswa_id'] as $key => $siswaId) {
                    $save = [];
                    $save['periode_id'] = $input['periode_id'];
                    $save['jurusan_id'] = $input['jurusan_id'];
                    $save['registration_type'] = 'seleksi';
                    $save['status']     = 'pending';

                    $save['siswa_id']   = $siswaId;
                    $response = $this->repository->register($save, $siswaId);
                }
                $response['data'] = $input;
            }
        } catch (QueryException $e) {
            $response['statusCode'] = 400;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    public function combo_siswa($tingkat_id, $jurusan_id)
    {
        // Hanya ambil data dengan is_active = true
        // $data = Siswa::select('id', 'name')
        $data = Siswa::selectRaw("CONCAT('[', nis, '] ', name) as name,id")
            ->where('is_active', true) // Filter data yang aktif
            ->where('is_pkl', false) // Filter data yang aktif
            ->where('tingkat_id', $tingkat_id) // Filter data yang aktif
            ->where('jurusan_id', $jurusan_id) // Filter data yang aktif
            ->whereNotNull('rombel_id')
            ->get();

        return $data->map(function ($item) {
            return [
                'id' => $item->id,
                'nis' => $item->id,
                'name' => ucwords($item->name),
            ];
        });
    }

    public function priode_pkl()
    {
        $data = PklPeriode::selectRaw("CONCAT('[', tahun_ajaran, '] ', name) as name,id,is_active")
            // ->where('is_active', true) // Filter data yang aktif
            ->orderBy('name', 'DESC')
            ->get();
        return $data->map(function ($item) {
            return [
                'id' => $item->id,
                'is_active' => $item->is_active,
                'name' => ucwords($item->name)
            ];
        });
    }

    public function table_registrasi(array $data)
    {
        $filter['pkl_registrations.jurusan_id'] = $data['jurusan'];
        $filter['periode_id'] = $data['priode'];

        if($data['tipe'] != 'all'){
            $filter['registration_type'] = $data['tipe'];
        }
        $where = $filter;
        return DataTableService::draw('pkl_registrations')
            ->where($where)
            // ->select(['users.id', 'users.name', 'users.email', 'users.is_active', 'roles.name AS role_name'])
            ->join('siswas', [
                ['siswas.id', '=', 'pkl_registrations.siswa_id'],
            ])
            ->addColumn('status_badge', function ($detail) {
                return getBadgeStatus($detail->status);
            })
            ->addColumn('action', function ($detail) {
                return '
                <div class="d-inline-block">
                    <a href="javascript:void(0);" class="btn btn-sm rounded-pill btn-icon dropdown-toggle hide-arrow show" data-bs-toggle="dropdown" aria-expanded="true"><i class="ti ti-dots-vertical ti-md"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end m-0" data-popper-placement="bottom-end">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="onDetails(this)" data-params="' . base64_encode(json_encode($detail)) . '">Detail</a>
                        </li>
                    </ul>
                </div>
                ';
            })
            ->rawColumns(['status_badge', 'action'])
            ->toJson();
    }

    public function table()
    {
        return DataTableService::draw('jurusans')
            ->where('is_active', true)
            ->where('deleted_at', null)
            ->addColumn('total', function ($detail) {
                return '0';
            })
            ->addColumn('diterima', function ($detail) {
                return '0';
            })
            ->addColumn('ditolak', function ($detail) {
                return '0';
            })
            ->addColumn('action', function ($detail) {
                return '
                <div class="d-inline-block">
                    <a href="javascript:void(0);" class="btn btn-sm rounded-pill btn-icon dropdown-toggle hide-arrow show" data-bs-toggle="dropdown" aria-expanded="true"><i class="ti ti-dots-vertical ti-md"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end m-0" data-popper-placement="bottom-end">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="onDetails(this)" data-params="' . base64_encode(json_encode($detail)) . '">Detail</a>
                        </li>
                    </ul>
                </div>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
    }
}
