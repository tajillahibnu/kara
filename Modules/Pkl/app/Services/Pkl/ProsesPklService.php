<?php

namespace Modules\Pkl\Services\Pkl;

use App\Models\Jurusan;
use App\Services\DataTableService;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Modules\Pkl\Repositories\ProsesRegistrasiPklRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProsesPklService
{

    protected $repository;
    public function __construct(
        ProsesRegistrasiPklRepository $repository,
    ) {
        $this->repository = $repository;
    }

    public function acc_pkl($id, array $data)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            if ($data['task'] === 'bypass') {
                $response['data'] = $this->repository->saveAccAll($id);
            } else {
                $response['data'] = $this->repository->saveAcc($id);
            }
        } catch (NotFoundHttpException $e) {
            $response['message'] = "Item with ID $id not found for update";
            throw new NotFoundHttpException($response['message']);
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            throw new Exception("Failed to update item" . $e->getMessage(), 500);
        }
        return $response;
    }

    public function rejected_pkl($id, array $data)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            if (!empty($data['task'])) {
                $response['data'] = $this->repository->saveRejectAll($id);
            } else {
                $response['data'] = $this->repository->saveReject($id);
            }
        } catch (NotFoundHttpException $e) {
            $response['message'] = "Item with ID $id not found for update";
            throw new NotFoundHttpException($response['message']);
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            throw new Exception("Failed to update item" . $e->getMessage(), 500);
        }
        return $response;
    }


    /**
     * Menampilkan data dalam bentuk DataTable.
     *
     * @return mixed Data dalam format JSON untuk DataTable.
     */
    public function table($role)
    {
        $getSetting = getSiteMeta();
        $tahunPelajaran = $getSetting['kbm']['tahun_pelajaran'];
        if ($role == 'super_admin' || $role == 'admin_sekolah') {
            $query = DataTableService::draw('pkl_registrations')
                ->select(['pkl_registrations.*', 'siswas.name', 'siswas.nis', 'siswas.rombel_name', 'siswas.jurusan_id', 'pkl_registrations.status_register AS status_role'])
                ->join('siswas', [
                    ['siswas.id', '=', 'pkl_registrations.siswa_id'],
                ]);
            $query->where('pkl_registrations.status_register','mandiri');
        } else {
            $role_id = session('active_role_id');
            $jurusanId = $this->repository->jurusanId();
            $query = DataTableService::draw('pkl_registration_statuses')
                ->select(['pkl_registrations.*', 'siswas.name', 'siswas.nis', 'siswas.rombel_name', 'siswas.jurusan_id', 'pkl_registration_statuses.status AS status_role'])
                ->join('siswas', [
                    ['siswas.id', '=', 'pkl_registration_statuses.siswa_id'],
                ])
                ->join('pkl_registrations', [
                    ['pkl_registrations.id', '=', 'pkl_registration_statuses.registration_id'],
                ])
                ->where('pkl_registration_statuses.jurusan_id', $jurusanId)
                ->where('pkl_registration_statuses.role_id', $role_id);
        }

        return $query->where('tahun_pelajaran', $tahunPelajaran)
            ->addColumn('jurusan', function ($detail) {
                return Cache::remember("jurusan_{$detail->jurusan_id}", now()->addMinutes(5), function () use ($detail) {
                    return Jurusan::find($detail->jurusan_id)->name ?? 'Unknown';
                });
            })
            ->addColumn('status_badge', function ($detail) {
                return getBadgeStatus($detail->status_role);
            })
            ->addColumn('action', function ($detail) use ($role) {
                $btnMore = '';
                $btnview = '';
                switch ($role) {
                    case 'super_admin':
                    case 'admin_sekolah':
                        $btnview .= '<a class="btn btn-icon" href="javascript:void(0);" data-permision="user-update" onclick="editData(this)" data-params="' . base64_encode(json_encode($detail)) . '"><i class="ti ti-edit ti-md"></i></a>';
                        $btnMore .= '<a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="confirmAll(this,' . "'bypass'" . ')" data-task="bypass" data-tipe="completed" data-params="' . base64_encode(json_encode($detail)) . '">Approve All</a>';
                        $btnMore .= '<a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="confirmAll(this,' . "'bypass'" . ')" data-task="bypass" data-tipe="rejected" data-params="' . base64_encode(json_encode($detail)) . '">Rejected All</a>';
                        break;
                    default:
                        $btnview .= '<a class="btn btn-icon" href="javascript:void(0);" data-permision="user-update" onclick="onDetails(this)" data-params="' . base64_encode(json_encode($detail)) . '"><i class="ti ti-eye ti-md"></i></a>';
                        // $btnMore .= '<a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="editData(this)" data-params="' . base64_encode(json_encode($detail)) . '">Edit</a>';
                        // $btnMore .= '<div class="dropdown-divider"></div>';
                        break;
                }

                $btnDropdown = $btnMore === '' ? '' : '
                        <div class="dropdown">
                            <a href="javascript:;" class="btn dropdown-toggle hide-arrow btn-icon p-0" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical ti-md"></i></a>
                            <div class="dropdown-menu dropdown-menu-end">
                                ' . $btnMore . '
                            </div>
                        </div>
                ';

                return '
                    <div class="d-flex align-items-center">
                        ' . $btnview . '
                        ' . $btnDropdown . '
                    </div>
                    ';
            })
            ->rawColumns(['status_badge', 'action'])
            ->toJson();
    }
}
